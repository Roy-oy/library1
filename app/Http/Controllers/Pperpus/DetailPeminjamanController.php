<?php

namespace App\Http\Controllers\Pperpus;

use App\Http\Controllers\Controller;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class DetailPeminjamanController extends Controller
{
    
    
    

    
    public function perpanjang(Request $request, Peminjaman $peminjaman, DetailPeminjaman $detail)
    {
        abort_if($detail->id_peminjaman !== $peminjaman->id_peminjaman, 403);

        if ($detail->sumber_buku !== 'buku perpus') {
            return back()->with('error', 'Buku BOS tidak bisa diperpanjang masa pinjamnya.');
        }

        if (!in_array($detail->status_detail, ['dipinjam'])) {
            return back()->with('error', 'Buku sudah terlambat atau sudah dikembalikan, tidak bisa diperpanjang.');
        }

        $request->validate([
            'tanggal_perpanjangan' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $detail->update([
            'tanggal_jatuh_tempo' => \Carbon\Carbon::parse($request->tanggal_perpanjangan)->startOfDay(),
        ]);

        $routePrefix = $detail->sumber_buku === 'bos' ? 'bos' : 'perpustakaan';

        return redirect()
            ->route("pperpus.peminjaman.{$routePrefix}.show", $peminjaman->id_peminjaman)
            ->with('success', "Masa pinjam berhasil diperpanjang hingga " . \Carbon\Carbon::parse($request->tanggal_perpanjangan)->format('d/m/Y') . ".");
    }

    
    
    

    
    public function hitungUlangDenda(Peminjaman $peminjaman, DetailPeminjaman $detail)
    {
        abort_if($detail->id_peminjaman !== $peminjaman->id_peminjaman, 403);

        if ($detail->sumber_buku !== 'buku perpus') {
            return back()->with('info', 'Buku BOS tidak punya denda harian otomatis.');
        }

        if ($detail->tanggal_jatuh_tempo === null) {
            return back()->with('error', 'Tanggal jatuh tempo belum diisi.');
        }

        $acuan = $detail->tanggal_kembali ?? now();
        $hari  = max(0, (int) $detail->tanggal_jatuh_tempo->diffInDays($acuan, false));
        $denda = $hari * $detail->denda_harian;

        $detail->update([
            'jumlah_hari_terlambat' => $hari,
            'jumlah_denda'          => $denda,
            'status_denda'          => $denda > 0 ? 'belum_lunas' : 'tidak_ada_denda',
            'status_detail'         => $hari > 0 && $detail->tanggal_kembali === null
                ? 'terlambat'
                : $detail->status_detail,
        ]);

        $peminjaman->syncStatus();

        $routePrefix = $detail->sumber_buku === 'bos' ? 'bos' : 'perpustakaan';

        return redirect()
            ->route("pperpus.peminjaman.{$routePrefix}.show", $peminjaman->id_peminjaman)
            ->with('success', "Denda dihitung ulang: {$hari} hari × Rp" . number_format($detail->denda_harian, 0, ',', '.') . " = Rp" . number_format($denda, 0, ',', '.'));
    }

    
    
    

    
    public function destroy(Peminjaman $peminjaman, DetailPeminjaman $detail)
    {
        abort_if($detail->id_peminjaman !== $peminjaman->id_peminjaman, 403);

        if (!in_array($detail->status_detail, ['dipinjam'])) {
            return back()->with('error', 'Tidak bisa membatalkan buku yang sudah diproses.');
        }

        DB::transaction(function () use ($detail, $peminjaman) {
            
            $buku = $detail->buku;
            $buku->increment('stok');
            if ($buku->stok > 0 && $buku->status_buku === 'habis') {
                $buku->update(['status_buku' => 'tersedia']);
            }

            $detail->delete();
            $peminjaman->syncStatus();
        });

        $routePrefix = $detail->sumber_buku === 'bos' ? 'bos' : 'perpustakaan';

        return redirect()
            ->route("pperpus.peminjaman.{$routePrefix}.show", $peminjaman->id_peminjaman)
            ->with('success', 'Satu buku berhasil dibatalkan dari daftar pinjaman.');
    }
}