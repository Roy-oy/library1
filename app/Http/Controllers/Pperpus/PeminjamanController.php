<?php

namespace App\Http\Controllers\Pperpus;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use App\Models\Siswa;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PeminjamanController extends Controller
{
    
    
    

    public function indexPerpustakaan(Request $request)
    {
        $query = Peminjaman::whereHas('details', function($q) {
                $q->where('sumber_buku', 'buku perpus');
            })
            ->withCount(['details as terlambat_count' => function ($q) {
                $q->where('status_detail', 'terlambat');
            }])
            ->with(['siswa', 'details.buku'])
            ->orderByDesc('terlambat_count')
            ->latest('tanggal_pinjam');

        if ($request->filled('status')) {
            if ($request->status === 'dipinjam') {
                $query->whereIn('status_peminjaman', ['dipinjam', 'dikembalikan']);
            } elseif ($request->status === 'telat') {
                $query->where('status_peminjaman', 'dipinjam')
                      ->whereHas('details', function ($q) {
                          $q->where(function ($sq) {
                              $sq->where('status_detail', 'terlambat')
                                 ->orWhere(function ($ssq) {
                                     $ssq->where('status_detail', 'dipinjam')
                                         ->whereNotNull('tanggal_jatuh_tempo')
                                         ->whereDate('tanggal_jatuh_tempo', '<', now()->startOfDay());
                                 });
                          });
                      });
            } else {
                $query->where('status_peminjaman', $request->status);
            }
        }
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }
        if ($request->filled('dari')) {
            $query->whereDate('tanggal_pinjam', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_pinjam', '<=', $request->sampai);
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('kode_peminjaman', 'like', "%{$q}%")
                    ->orWhereHas('siswa', fn($s) => $s->where('nama_siswa', 'like', "%{$q}%")
                        ->orWhere('nis', 'like', "%{$q}%"));
            });
        }

        $peminjamans = $query->paginate(15)->withQueryString();
        return view('pperpus.peminjaman.perpustakaan.index', compact('peminjamans'));
    }

    public function createPerpustakaan()
    {
        $bukuPerpusPerKategori = Buku::with('kategoriBuku')
            ->where('sumber_buku', 'buku perpus')
            ->where('status_buku', 'tersedia')
            ->whereNull('deleted_at')
            ->whereNotNull('id_kategori')
            ->orderBy('id_kategori')
            ->orderBy('judul_buku')
            ->get()
            ->groupBy(fn($b) => $b->kategoriBuku->nama_kategori ?? 'Tanpa Kategori');

        $siswas = Siswa::where('status', 'aktif')
            ->whereNull('deleted_at')
            ->orderBy('nama_siswa')
            ->get(['id_siswa', 'nis', 'nama_siswa', 'kelas']);

        $kodePeminjaman = Peminjaman::generateKode();

        return view('pperpus.peminjaman.perpustakaan.create', compact(
            'siswas',
            'bukuPerpusPerKategori',
            'kodePeminjaman'
        ));
    }

    public function storePerpustakaan(Request $request)
    {
        $request->validate([
            'id_siswa'           => ['required', 'exists:siswa,id_siswa'],
            'tanggal_pinjam'     => ['required', 'date'],
            'tanggal_kembali'    => ['required', 'date', 'after_or_equal:tanggal_pinjam'],
            'keterangan'         => ['nullable', 'string', 'max:500'],
            'buku'               => ['required', 'array', 'min:1'],
            'buku.*.id_buku'     => ['required', 'distinct', 'exists:buku,id_buku'],
        ], [
            'buku.required'         => 'Minimal satu buku perpustakaan harus dipilih.',
            'buku.*.id_buku.distinct'=> 'Buku yang sama tidak boleh dipilih dua kali.',
        ]);

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::create([
                'id_siswa'          => $request->id_siswa,
                'kode_peminjaman'   => Peminjaman::generateKode(),
                'tanggal_pinjam'    => $request->tanggal_pinjam,
                'status_peminjaman' => 'dipinjam',
                'keterangan'        => $request->keterangan,
            ]);

            foreach ($request->buku as $item) {
                $buku = Buku::lockForUpdate()->findOrFail($item['id_buku']);

                if ($buku->stok <= 0 || $buku->status_buku === 'habis') {
                    throw new \Exception("Stok buku \"{$buku->judul_buku}\" sudah habis.");
                }

                $jatuhTempo = \Carbon\Carbon::parse($request->tanggal_kembali)->startOfDay();
                $dendaHarian = DetailPeminjaman::DENDA_HARIAN_PERPUS;

                DetailPeminjaman::create([
                    'id_peminjaman'        => $peminjaman->id_peminjaman,
                    'id_buku'              => $buku->id_buku,
                    'sumber_buku'          => $buku->sumber_buku,
                    'tanggal_jatuh_tempo'  => $jatuhTempo,
                    'tanggal_kembali'      => null,
                    'status_detail'        => 'dipinjam',
                    'denda_harian'         => $dendaHarian,
                    'jumlah_hari_terlambat'=> 0,
                    'jumlah_denda'         => 0,
                    'status_denda'         => 'tidak_ada_denda',
                ]);

                $buku->decrement('stok');
                if ($buku->stok <= 0) {
                    $buku->update(['status_buku' => 'habis']);
                }
            }

            DB::commit();
            return redirect()
                ->route('pperpus.peminjaman.perpustakaan.show', $peminjaman->id_peminjaman)
                ->with('success', "Peminjaman Perpustakaan {$peminjaman->kode_peminjaman} berhasil disimpan.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function showPerpustakaan(Peminjaman $peminjaman)
    {
        $peminjaman->load(['siswa', 'details.buku.kategoriBuku']);
        foreach ($peminjaman->details as $detail) {
            if ($detail->is_terlambat && $detail->status_detail === 'dipinjam') {
                $detail->update(['status_detail' => 'terlambat']);
            }
        }
        $peminjaman->syncStatus();
        $peminjaman->refresh()->load(['details.buku.kategoriBuku']);
        return view('pperpus.peminjaman.perpustakaan.show', compact('peminjaman'));
    }

    
    
    

    public function indexBos(Request $request)
    {
        $query = Peminjaman::whereHas('details', function($q) {
                $q->where('sumber_buku', 'bos');
            })
            ->withCount(['details as terlambat_count' => function ($q) {
                $q->where('status_detail', 'terlambat');
            }])
            ->with(['siswa', 'details.buku'])
            ->orderByDesc('terlambat_count')
            ->latest('tanggal_pinjam');

        if ($request->filled('status')) {
            $query->where('status_peminjaman', $request->status);
        }
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }
        if ($request->filled('dari')) {
            $query->whereDate('tanggal_pinjam', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_pinjam', '<=', $request->sampai);
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('kode_peminjaman', 'like', "%{$q}%")
                    ->orWhereHas('siswa', fn($s) => $s->where('nama_siswa', 'like', "%{$q}%")
                        ->orWhere('nis', 'like', "%{$q}%"));
            });
        }

        $peminjamans = $query->paginate(15)->withQueryString();
        $kelasList = Siswa::where('status', 'aktif')->select('kelas')->distinct()->pluck('kelas')->toArray();
        return view('pperpus.peminjaman.bos.index', compact('peminjamans', 'kelasList'));
    }

    public function createBos()
    {
        $kodePeminjaman = Peminjaman::generateKode();
        $siswas = Siswa::where('status', 'aktif')->orderBy('nama_siswa')->get();
        $kelasList = Siswa::where('status', 'aktif')->select('kelas')->distinct()->pluck('kelas')->toArray();
        if (empty($kelasList)) {
            $kelasList = ['VII-A', 'VII-B', 'VIII-A', 'VIII-B', 'IX-A', 'IX-B'];
        }
        return view('pperpus.peminjaman.bos.create', compact('kodePeminjaman', 'kelasList', 'siswas'));
    }

    public function storeBos(Request $request)
    {
        $request->validate([
            'id_siswa'           => ['required', 'exists:siswa,id_siswa'],
            'tanggal_pinjam'     => ['required', 'date'],
            'buku_bos'           => ['required', 'array', 'min:1'],
            'buku_bos.*'         => ['required', 'exists:buku,id_buku'],
        ], [
            'buku_bos.required'  => 'Minimal satu buku BOS harus dipilih.',
        ]);

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::create([
                'id_siswa'          => $request->id_siswa,
                'kode_peminjaman'   => Peminjaman::generateKode(),
                'tanggal_pinjam'    => $request->tanggal_pinjam,
                'status_peminjaman' => 'dipinjam',
                'keterangan'        => 'Peminjaman Buku BOS',
            ]);

            foreach ($request->buku_bos as $id_buku) {
                $buku = Buku::lockForUpdate()->findOrFail($id_buku);

                if ($buku->stok <= 0 || $buku->status_buku === 'habis') {
                    throw new \Exception("Stok buku BOS \"{$buku->judul_buku}\" sudah habis.");
                }

                $jatuhTempo = null; 
                $dendaHarian = DetailPeminjaman::DENDA_HARIAN_BOS;

                DetailPeminjaman::create([
                    'id_peminjaman'        => $peminjaman->id_peminjaman,
                    'id_buku'              => $buku->id_buku,
                    'sumber_buku'          => 'bos',
                    'tanggal_jatuh_tempo'  => $jatuhTempo,
                    'tanggal_kembali'      => null,
                    'status_detail'        => 'dipinjam',
                    'denda_harian'         => $dendaHarian,
                    'jumlah_hari_terlambat'=> 0,
                    'jumlah_denda'         => 0,
                    'status_denda'         => 'tidak_ada_denda',
                ]);

                $buku->decrement('stok');
                if ($buku->stok <= 0) {
                    $buku->update(['status_buku' => 'habis']);
                }
            }

            DB::commit();
            return redirect()
                ->route('pperpus.peminjaman.bos.show', $peminjaman->id_peminjaman)
                ->with('success', "Peminjaman BOS {$peminjaman->kode_peminjaman} berhasil disimpan.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function showBos(Peminjaman $peminjaman)
    {
        $peminjaman->load(['siswa', 'details.buku']);
        foreach ($peminjaman->details as $detail) {
            if ($detail->is_terlambat && $detail->status_detail === 'dipinjam') {
                $detail->update(['status_detail' => 'terlambat']);
            }
        }
        $peminjaman->syncStatus();
        $peminjaman->refresh()->load(['details.buku']);
        return view('pperpus.peminjaman.bos.show', compact('peminjaman'));
    }

    
    
    

    public function indexPengembalianPerpustakaan(Request $request)
    {
        $query = Peminjaman::whereHas('details', function($q) {
                $q->where('sumber_buku', 'buku perpus');
            })->with(['siswa', 'details.buku'])
            ->latest('tanggal_pinjam');

        if ($request->filled('status')) {
            if ($request->status === 'dipinjam') {
                $query->whereIn('status_peminjaman', ['dipinjam', 'dikembalikan']);
            } else {
                $query->where('status_peminjaman', $request->status);
            }
        }

        if ($request->filled('dari')) {
            $query->whereDate('tanggal_pinjam', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_pinjam', '<=', $request->sampai);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('kode_peminjaman', 'like', "%{$q}%")
                    ->orWhereHas('siswa', fn($s) => $s->where('nama_siswa', 'like', "%{$q}%")
                        ->orWhere('nis', 'like', "%{$q}%"));
            });
        }

        $peminjamans = $query->paginate(15)->withQueryString();
        return view('pperpus.pengembalian.perpustakaan.index', compact('peminjamans'));
    }

    public function formKembaliPerpustakaan(Peminjaman $peminjaman)
    {
        $peminjaman->load(['siswa', 'details.buku.kategoriBuku']);
        $bukuMasihDipinjam = $peminjaman->details()
            ->where('sumber_buku', 'buku perpus')
            ->whereIn('status_detail', ['dipinjam', 'terlambat'])
            ->with('buku.kategoriBuku')
            ->get();

        if ($bukuMasihDipinjam->isEmpty()) {
            return redirect()
                ->route('pperpus.peminjaman.perpustakaan.show', $peminjaman->id_peminjaman)
                ->with('info', 'Semua buku perpustakaan sudah dikembalikan.');
        }
        return view('pperpus.pengembalian.perpustakaan.kembali', compact('peminjaman', 'bukuMasihDipinjam'));
    }

    public function prosesKembaliPerpustakaan(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'detail'                   => ['required', 'array', 'min:1'],
            'detail.*.id_detail'       => ['required', 'exists:detail_peminjaman,id_detail'],
            'detail.*.kondisi'         => ['required', Rule::in(['baik', 'rusak', 'hilang'])],
            'detail.*.denda_ganti'     => ['nullable', 'integer', 'min:0'],
            'detail.*.tanggal_kembali' => ['nullable', 'date'],
            'detail.*.keterangan'      => ['nullable', 'string', 'max:500'],
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->detail as $item) {
                $detail = DetailPeminjaman::with('buku')
                    ->lockForUpdate()
                    ->where('id_detail', $item['id_detail'])
                    ->where('id_peminjaman', $peminjaman->id_peminjaman)
                    ->firstOrFail();

                if (!in_array($detail->status_detail, ['dipinjam', 'terlambat'])) {
                    continue;
                }

                $tanggalKembali = $item['tanggal_kembali']
                    ? \Carbon\Carbon::parse($item['tanggal_kembali'])
                    : now();

                if ($item['kondisi'] === 'baik') {
                    $detail->prosesPengembalian($tanggalKembali, $item['keterangan'] ?? null);
                } else {
                    $dendaGanti = (int) ($item['denda_ganti'] ?? 0);
                    $detail->prosesHilangAtauRusak($item['kondisi'], $dendaGanti, $item['keterangan'] ?? null);
                }

                $buku = $detail->buku;
                $buku->increment('stok');
                if ($buku->stok > 0 && $buku->status_buku === 'habis') {
                    $buku->update(['status_buku' => 'tersedia']);
                }
            }

            $peminjaman->syncStatus();
            DB::commit();

            if ($peminjaman->ada_denda_belum_lunas) {
                return redirect()
                    ->route('pperpus.peminjaman.perpustakaan.show', $peminjaman->id_peminjaman)
                    ->with('success', 'Pengembalian buku perpustakaan berhasil diproses. Silakan selesaikan pembayaran denda.');
            }

            return redirect()
                ->route('pperpus.pengembalian.perpustakaan.index')
                ->with('success', 'Pengembalian buku perpustakaan berhasil diproses.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function lunasDendaPerpustakaan(Request $request, Peminjaman $peminjaman, DetailPeminjaman $detail)
    {
        abort_if($detail->id_peminjaman !== $peminjaman->id_peminjaman, 403);
        abort_if($detail->status_denda !== 'belum_lunas', 422, 'Denda sudah lunas atau tidak ada denda.');

        $detail->lunaskanDenda();
        return redirect()
            ->route('pperpus.peminjaman.perpustakaan.show', $peminjaman->id_peminjaman)
            ->with('success', 'Denda berhasil dilunaskan.');
    }

    public function lunasSemuaDendaPerpustakaan(Peminjaman $peminjaman)
    {
        DB::transaction(function () use ($peminjaman) {
            $peminjaman->details()
                ->where('status_denda', 'belum_lunas')
                ->each(function ($detail) {
                    $detail->status_denda = 'lunas';
                    if ($detail->status_detail === 'terlambat') {
                        $detail->status_detail = 'dikembalikan';
                    }
                    $detail->save();
                });
            $peminjaman->syncStatus();
        });
        return redirect()
            ->route('pperpus.peminjaman.perpustakaan.show', $peminjaman->id_peminjaman)
            ->with('success', 'Semua denda berhasil dilunaskan.');
    }

    public function lunasSemuaDendaBos(Peminjaman $peminjaman)
    {
        DB::transaction(function () use ($peminjaman) {
            $peminjaman->details()
                ->where('status_denda', 'belum_lunas')
                ->each(function ($detail) {
                    $detail->status_denda = 'lunas';
                    if ($detail->status_detail === 'terlambat') {
                        $detail->status_detail = 'dikembalikan';
                    }
                    $detail->save();
                });
            $peminjaman->syncStatus();
        });
        return redirect()
            ->route('pperpus.peminjaman.bos.show', $peminjaman->id_peminjaman)
            ->with('success', 'Semua denda BOS berhasil dilunaskan.');
    }

    
    
    

    public function formAkhirTahunBos()
    {
        $rawData = DetailPeminjaman::bukuBos()
            ->dipinjam()
            ->with(['peminjaman.siswa', 'buku'])
            ->get();
            
        $structuredData = [];
        foreach ($rawData as $detail) {
            if (!$detail->peminjaman || !$detail->peminjaman->siswa) continue;
            
            $kelas = $detail->peminjaman->siswa->kelas;
            $idSiswa = $detail->peminjaman->siswa->id_siswa;
            $namaSiswa = $detail->peminjaman->siswa->nama_siswa;
            $nis = $detail->peminjaman->siswa->nis;

            if (!isset($structuredData[$kelas])) {
                $structuredData[$kelas] = [];
            }
            if (!isset($structuredData[$kelas][$idSiswa])) {
                $structuredData[$kelas][$idSiswa] = [
                    'id_siswa' => $idSiswa,
                    'nama_siswa' => $namaSiswa,
                    'nis' => $nis,
                    'buku' => []
                ];
            }
            
            $structuredData[$kelas][$idSiswa]['buku'][] = [
                'id_detail' => $detail->id_detail,
                'judul_buku' => $detail->buku->judul_buku,
                'kode_buku' => $detail->buku->kode_buku,
            ];
        }

        foreach ($structuredData as $kelas => &$siswas) {
            usort($siswas, fn($a, $b) => strcmp($a['nama_siswa'], $b['nama_siswa']));
            $siswas = array_values($siswas);
        }

        $kelasList = Siswa::where('status', 'aktif')->select('kelas')->distinct()->pluck('kelas')->toArray();
        if (empty($kelasList)) {
            $kelasList = ['VII-A', 'VII-B', 'VIII-A', 'VIII-B', 'IX-A', 'IX-B'];
        }

        return view('pperpus.pengembalian.bos.index', compact('structuredData', 'kelasList'));
    }

    public function prosesAkhirTahunBos(Request $request)
    {
        
        $request->validate([
            'detail'               => ['required', 'array', 'min:1'],
            'detail.*.id_detail'   => ['required', 'exists:detail_peminjaman,id_detail'],
            'detail.*.kondisi'     => ['required', Rule::in(['baik', 'rusak', 'hilang'])],
            'detail.*.denda_ganti' => ['nullable', 'integer', 'min:0'],
            'detail.*.keterangan'  => ['nullable', 'string'],
        ]);

        
        foreach ($request->detail as $index => $item) {
            if (in_array($item['kondisi'] ?? null, ['rusak', 'hilang'])) {
                if (empty($item['denda_ganti']) || (int)$item['denda_ganti'] === 0) {
                    return back()
                        ->withErrors([
                            "detail.{$index}.denda_ganti" => 'Denda ganti wajib diisi jika buku rusak atau hilang.'
                        ])
                        ->withInput();
                }
            }
        }

        DB::beginTransaction();
        $berhasil = 0;
        try {
            foreach ($request->detail as $item) {
                $detail = DetailPeminjaman::bukuBos()
                    ->dipinjam()
                    ->lockForUpdate()
                    ->find($item['id_detail']);

                if (!$detail) continue;

                if ($item['kondisi'] === 'baik') {
                    $detail->prosesPengembalian(now(), $item['keterangan'] ?? null);
                    
                    
                    $detail->buku->increment('stok');
                    if ($detail->buku->stok > 0 && $detail->buku->status_buku === 'habis') {
                        $detail->buku->update(['status_buku' => 'tersedia']);
                    }
                } else {
                    $detail->prosesHilangAtauRusak(
                        $item['kondisi'],
                        (int) ($item['denda_ganti'] ?? 0),
                        $item['keterangan'] ?? null
                    );
                    
                }

                $detail->peminjaman->syncStatus();
                $berhasil++;
            }

            DB::commit();
            return redirect()
                ->route('pperpus.pengembalian.bos.index')
                ->with('success', "Berhasil! {$berhasil} buku BOS telah diproses kembali. Data siswa akan diperbarui secara otomatis di daftar.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    
    
    

    public function cekPeminjamanAktifSiswa(Siswa $siswa)
    {
        $aktif = Peminjaman::where('id_siswa', $siswa->id_siswa)
            ->where('status_peminjaman', 'dipinjam')
            ->with(['details.buku'])
            ->latest()
            ->get();

        return response()->json([
            'ada_peminjaman_aktif' => $aktif->isNotEmpty(),
            'jumlah'               => $aktif->count(),
            'peminjamans'          => $aktif->map(fn($p) => [
                'kode'          => $p->kode_peminjaman,
                'tanggal'       => $p->tanggal_pinjam->format('d/m/Y'),
                'jumlah_buku'   => $p->details->count(),
                'ada_terlambat' => $p->ada_terlambat,
            ]),
        ]);
    }

    public function cekKetersediaanBuku(Buku $buku)
    {
        return response()->json([
            'id_buku'     => $buku->id_buku,
            'judul_buku'  => $buku->judul_buku,
            'sumber_buku' => $buku->sumber_buku,
            'stok'        => $buku->stok,
            'tersedia'    => $buku->stok > 0 && $buku->status_buku === 'tersedia',
        ]);
    }

    public function getBuku(Request $request)
    {
        $id_kategori = $request->id_kategori;
        $kelas       = $request->kelas;
        $sumber      = $request->sumber;

        $query = Buku::where('status_buku', 'tersedia');

        if ($id_kategori) {
            $query->where('id_kategori', $id_kategori);
        }
        if ($kelas) {
            $query->where('kelas', $kelas);
        }
        if ($sumber) {
            $query->where('sumber_buku', $sumber);
        }

        $buku = $query->get();
        return response()->json($buku);
    }

    public function getSiswaByKelas(Request $request)
    {
        $siswa = Siswa::where('kelas', $request->kelas)
            ->where('status', 'aktif')
            ->orderBy('nama_siswa')
            ->get();
        return response()->json($siswa);
    }

    public function kembalikan(Request $request, $id_detail)
    {
        $request->validate([
            'tanggal_pengembalian' => 'required|date',
            'status_buku'          => 'required|in:kembali,rusak,hilang',
            'keterangan'           => 'nullable|string',
            'denda_ganti'          => 'nullable|integer|min:0'
        ]);

        $detail = DetailPeminjaman::findOrFail($id_detail);
        
        DB::beginTransaction();
        try {
            if ($request->status_buku === 'kembali') {
                $detail->prosesPengembalian(\Carbon\Carbon::parse($request->tanggal_pengembalian), $request->keterangan);
            } else {
                $dendaGanti = $request->denda_ganti ?? 0;
                $detail->prosesHilangAtauRusak($request->status_buku, $dendaGanti, $request->keterangan);
            }

            $buku = $detail->buku;
            $buku->increment('stok');
            if ($buku->stok > 0 && $buku->status_buku === 'habis') {
                $buku->update(['status_buku' => 'tersedia']);
            }

            $detail->peminjaman->syncStatus();
            DB::commit();

            return redirect()->back()->with('success', 'Buku berhasil dikembalikan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function laporanDenda(Request $request)
    {
        $query = DetailPeminjaman::belumLunas()
            ->with(['peminjaman.siswa', 'buku'])
            ->orderByDesc('jumlah_denda');

        if ($request->filled('kelas')) {
            $query->whereHas('peminjaman.siswa', fn($q) => $q->where('kelas', $request->kelas));
        }

        $dendas   = $query->paginate(20)->withQueryString();
        $totalDenda = DetailPeminjaman::belumLunas()->sum('jumlah_denda');

        return view('pperpus.peminjaman.laporan-denda', compact('dendas', 'totalDenda'));
    }

    public function laporanTerlambat()
    {
        $terlambats = DetailPeminjaman::terlambat()
            ->with(['peminjaman.siswa', 'buku'])
            ->orderBy('tanggal_jatuh_tempo')
            ->paginate(20);

        return view('pperpus.peminjaman.laporan-terlambat', compact('terlambats'));
    }
}