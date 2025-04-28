<?php

/**
 *
 * @param $input
 * @param string print|dump|export
 * @return false|string
 */
function pre_dump($input, $type = 'print') {
    if ($type == 'print' OR $type == 'dump' OR $type == 'export') {
        echo "<pre>";
        if ($type == 'dump') {
            // https://www.php.net/manual/en/function.var-dump.php
            var_dump($input);
        }
        elseif ($type == 'export') {
            // https://www.php.net/manual/en/function.var-export.php
            var_export($input);
        }
        else {
            // https://www.php.net/manual/en/function.print-r.php
            print_r($input);
        }
        echo "</pre>";
    }
    else {
        return false;
    }
}
