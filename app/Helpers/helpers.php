<?php

if (!function_exists('upload_file')) {
    function upload_file($image, $folder)
    {
        $extention = $image->getClientOriginalExtension();
        $fileName = time() . '.' . $extention;
        $path = $image->storeAs($folder, $fileName, 'public');
        return $path;
    }
}
