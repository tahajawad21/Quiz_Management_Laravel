<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class FileHelper
{
    public static function fileExists($filePath)
    {
        return Storage::exists('public/' . $filePath);
    }
}
