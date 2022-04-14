<?php

$moduleUpdateUrl = 'https://api-addons.prestashop.com/?method=module&version=8.0&id_module=4181';
$moduleUpdateUrl = _PS_MODULE_DIR_ . 'test.zip';
$archiveFilepath = _PS_MODULE_DIR_ . 'module_update.zip';
file_put_contents($archiveFilepath, file_get_contents($moduleUpdateUrl));

if (file_exists($archiveFilepath)) {
    $zip = new ZipArchive();
    if ($zip->open($archiveFilepath) === true) {
        $zip->extractTo(_PS_MODULE_DIR_);
        $zip->close();
        unlink($archiveFilepath);
    }
}
