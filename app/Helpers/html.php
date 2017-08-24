<?php

function style_ts($path) {
    try {
        $ts = '?v='.File::lastModified(public_path().$path);
    }
    catch (Exception $e) {
        $ts = '';
    }
    return '<link rel="stylesheet" href="'.$path.$ts.'">';
}
function script_ts($path) {
    try {
        $ts = '?v='.File::lastModified(public_path().$path);
    }
    catch (Exception $e) {
        $ts = '';
    }
    return '<script src="'.$path.$ts.'"></script>';
}