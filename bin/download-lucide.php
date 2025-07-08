<?php

$url = 'https://github.com/lucide-icons/lucide/archive/refs/heads/main.zip';
$destDir = __DIR__ . '/../src/icons';

// Download and unzip the file
$zipFile = sys_get_temp_dir() . '/lucide.zip';
file_put_contents($zipFile, fopen($url, 'r'));

function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }
    if (!is_dir($dir)) {
        return unlink($dir);
    }
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }
    return rmdir($dir);
}

$zip = new ZipArchive;
if ($zip->open($zipFile) === TRUE) {
    $zip->extractTo($destDir);
    $zip->close();
    echo "Lucide icons downloaded successfully to $destDir\n";

    // Move lucide-main/icons to lucide
    $sourceDir = $destDir . '/lucide-main/icons';
    $targetDir = $destDir . '/lucide';

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $files = scandir($sourceDir);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            rename("$sourceDir/$file", "$targetDir/$file");
        }
    }

    // Remove the lucide-main directory and its contents
    deleteDirectory($destDir . '/lucide-main');
} else {
    echo "Failed to download Lucide icons.\n";
}

unlink($zipFile);