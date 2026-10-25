<?php

if (PHP_SAPI !== 'cli') {
    fwrite(STDERR, "Test runner ini hanya dapat dijalankan melalui CLI.\n");
    exit(1);
}

$projectRoot = dirname(__DIR__);
$excludedDirectories = ['.git', 'node_modules', 'vendor'];
$directory = new RecursiveDirectoryIterator(
    $projectRoot,
    FilesystemIterator::SKIP_DOTS
);
$filteredDirectory = new RecursiveCallbackFilterIterator(
    $directory,
    static function (SplFileInfo $file) use ($excludedDirectories): bool {
        return !$file->isDir() || !in_array($file->getFilename(), $excludedDirectories, true);
    }
);
$iterator = new RecursiveIteratorIterator($filteredDirectory);
$phpFiles = [];

foreach ($iterator as $file) {
    if ($file->isFile() && strtolower($file->getExtension()) === 'php') {
        $phpFiles[] = $file->getPathname();
    }
}

sort($phpFiles, SORT_STRING);

if ($phpFiles === []) {
    fwrite(STDERR, "Tidak ditemukan file PHP untuk diperiksa.\n");
    exit(1);
}

$passed = 0;
$failed = 0;

foreach ($phpFiles as $phpFile) {
    $process = proc_open(
        [PHP_BINARY, '-l', $phpFile],
        [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ],
        $pipes
    );

    if (!is_resource($process)) {
        fwrite(STDERR, "Gagal menjalankan pemeriksaan sintaks untuk {$phpFile}\n");
        $failed++;
        continue;
    }

    fclose($pipes[0]);
    $stdout = stream_get_contents($pipes[1]);
    $stderr = stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    $exitCode = proc_close($process);

    $relativePath = substr($phpFile, strlen($projectRoot) + 1);
    if (DIRECTORY_SEPARATOR !== '/') {
        $relativePath = str_replace(DIRECTORY_SEPARATOR, '/', $relativePath);
    }

    if ($exitCode === 0) {
        fwrite(STDOUT, "[PASS] {$relativePath}\n");
        $passed++;
        continue;
    }

    fwrite(STDERR, "[FAIL] {$relativePath}\n");
    if ($stdout !== '') {
        fwrite(STDERR, $stdout);
    }
    if ($stderr !== '') {
        fwrite(STDERR, $stderr);
    }
    $failed++;
}

fwrite(STDOUT, "\nHasil: {$passed} berhasil, {$failed} gagal.\n");
exit($failed === 0 ? 0 : 1);