<?php

require ('../../includes/include.php');

set_time_limit(3 * 60);

$run = true;
if ($_GET['count'] == 1) {
    $dir[] = $config['fs']['root'] . '/files/TENANTKEY/logs/raw/2022/07/';
    $dir[] = $config['fs']['root'] . '/files/TENANTKEY/logs/raw/2022/08/';
}
if ($_GET['count'] == 2) {
    $dir[] = $config['fs']['root'] . '/files/TENANTKEY/logs/raw/2022/09/';
    $dir[] = $config['fs']['root'] . '/files/TENANTKEY/logs/raw/2022/10/';
}
if ($_GET['count'] == 3) {
    $dir[] = $config['fs']['root'] . '/files/TENANTKEY/logs/raw/2022/11/';
    $dir[] = $config['fs']['root'] . '/files/TENANTKEY/logs/raw/2022/12/';
}
if ($_GET['count'] == 4) {
    $dir[] = $config['fs']['root'] . '/files/TENANTKEY/logs/raw/2023/01/';
    $dir[] = $config['fs']['root'] . '/files/TENANTKEY/logs/raw/2023/02/';
}
if ($_GET['count'] == 5) {
    $dir[] = $config['fs']['root'] . '/files/TENANTKEY/logs/raw/2023/03/';
    $dir[] = $config['fs']['root'] . '/files/TENANTKEY/logs/raw/2023/04/';
}
if ($_GET['count'] == 6) {
    $dir[] = $config['fs']['root'] . '/files/TENANTKEY/logs/raw/2023/05/';
    $dir[] = $config['fs']['root'] . '/files/TENANTKEY/logs/raw/2023/06/';
}
if ($_GET['count'] == 7) {
    $dir[] = $config['fs']['root'] . '/files/TENANTKEY/logs/raw/2023/07/';
    $dir[] = $config['fs']['root'] . '/files/TENANTKEY/logs/raw/2023/08/';
}

$dir_import = $config['fs']['root'] . '/files/TENANTKEY/logs/import/';

if ($run) {
    foreach ($dir AS $folder) {
        $files = scandir($folder, SCANDIR_SORT_ASCENDING);
        if (($key = array_search('.', $files)) !== false) {
            unset($files[$key]);
        }
        if (($key = array_search('..', $files)) !== false) {
            unset($files[$key]);
        }
        echo'<font style="color: red; background-color: #ffff42;">' . count($files) . ' Files in folder ' . $folder . '</font><br />';

        foreach ($files as $file) {
            if (file_exists($folder . $file)) {
                if (rename($folder . $file, $dir_import . $file)) {
                    echo "From: " . $folder . $file . "<br />";
                    echo "To: " . $dir_import . $file . "<br />";
                }
                else {
                    echo'<font style="color: red; background-color: #ffff42;">FAILED: Filename: ' . $folder . $file . '</font><br />';
                }
            }
            else {
                echo "Filename: " . $file . " can't be copied. Error: 404<br />";
            }
        }
        echo "<b>Done!</b><br />";
    }
}
else {
    echo "Disabled";
}