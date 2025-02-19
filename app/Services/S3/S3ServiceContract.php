<?php

namespace App\Services\S3;

use Illuminate\Http\UploadedFile;

interface S3ServiceContract
{
    public static function uploadFile(string $fileId, UploadedFile $file);
    public static function deleteFile(string $fileId);
}
