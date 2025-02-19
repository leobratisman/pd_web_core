<?php

namespace App\Services\S3;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class S3ImageService implements S3ServiceContract
{
    private const FILE_TYPE = '.webp';


    public static function uploadFile(string $fileId, UploadedFile $file)
    {
        $fileName = $fileId . self::FILE_TYPE;
        $fileContent = $file->get();
        Storage::disk('s3')->put($fileName, $fileContent);
    }

    public static  function  deleteFile(string $fileId)
    {
        $fileName = $fileId . self::FILE_TYPE;
        Storage::disk('s3')->delete($fileName);
    }
}
