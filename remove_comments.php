<?php

function stripCommentsPhp($code) {
    $tokens = token_get_all($code);
    $output = '';
    foreach ($tokens as $token) {
        if (is_array($token)) {
            if ($token[0] === T_COMMENT || $token[0] === T_DOC_COMMENT) {
                // If the comment has newlines, preserve them so line numbering doesn't completely break, 
                // but actually removing them entirely is usually what people want. We will just strip them.
                continue;
            }
            $output .= $token[1];
        } else {
            $output .= $token;
        }
    }
    return $output;
}

function stripCommentsBlade($content) {
    // Remove Blade comments
    $content = preg_replace('/\{\{--.*?--\}\}/s', '', $content);
    // Remove HTML comments
    $content = preg_replace('/<!--.*?-->/s', '', $content);
    // Remove CSS/JS multi-line comments
    $content = preg_replace('/\/\*.*?\*\//s', '', $content);
    // Remove full-line JS/PHP style single-line comments in Blade
    $content = preg_replace('/^\s*\/\/.*$/m', '', $content);
    return $content;
}

$directories = [
    'app/Http/Controllers/Kperpus',
    'app/Http/Controllers/Pperpus',
    'app/Http/Controllers/Ksekolah',
    'app/Models',
    'resources/views/kperpus',
    'resources/views/pperpus',
    'resources/views/ksekolah',
];

$baseDir = 'd:/erp/library/';

$count = 0;
foreach ($directories as $dir) {
    $path = $baseDir . $dir;
    if (!is_dir($path)) continue;
    
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $ext = $file->getExtension();
            $filename = $file->getFilename();
            $filepath = $file->getPathname();
            
            $content = file_get_contents($filepath);
            $newContent = $content;
            
            if (strpos($filename, '.blade.php') !== false) {
                $newContent = stripCommentsBlade($content);
            } elseif ($ext === 'php') {
                $newContent = stripCommentsPhp($content);
            }
            
            if ($newContent !== $content) {
                file_put_contents($filepath, $newContent);
                echo "Cleaned: $filepath\n";
                $count++;
            }
        }
    }
}
echo "Done cleaning $count files.\n";
