<?php

//Fetch the true updated module here
$moduleUpdateUrl = 'https://api-addons.prestashop.com/?method=module&version=8.0&id_module=4181';

// Test purpose
$moduleUpdateUrl = _PS_MODULE_DIR_ . 'test.zip';

$archiveFilepath = _PS_MODULE_DIR_ . 'module_mbo_update.zip';
file_put_contents($archiveFilepath, file_get_contents($moduleUpdateUrl));

if (file_exists($archiveFilepath)) {
    $zip = new ZipArchive();
    if ($zip->open($archiveFilepath) === true) {
        deleteFolder(_PS_MODULE_DIR_ . 'ps_mbo', true);
        $zip->extractTo(_PS_MODULE_DIR_);
        $zip->close();
        unlink($archiveFilepath);
    }
}

function deleteFolder($folder, $rootFolder = false)
{
    $filesToKeep = [
        'autoupgrade.php',
    ];

    $dir = opendir($folder);
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            $full = $folder . '/' . $file;
            if (is_dir($full)) {
                deleteFolder($full);
            } elseif (!in_array($file, $filesToKeep)) {
                unlink($full);
            }
        }
    }
    closedir($dir);
    if (!$rootFolder) {
        rmdir($folder);
    }
}
