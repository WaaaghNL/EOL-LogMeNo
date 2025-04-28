<?php

class FileSystem {

    public function scandir($dir, $sorting = SCANDIR_SORT_ASCENDING) {
        $files = scandir($dir, $sorting);

        if (($key = array_search('.', $files)) !== false) {
            unset($files[$key]);
        }
        if (($key = array_search('..', $files)) !== false) {
            unset($files[$key]);
        }
        return $files;
    }
}
