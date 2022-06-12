<?php

namespace App\Helpers;

class UploadHelper
{
    public static function upload ($data, $folderName) {
        return $data->store($folderName,'public');
    }
}
