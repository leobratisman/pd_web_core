<?php

namespace App\Services\S3;

use App\Exceptions\FileLoadingException;
use App\Exceptions\S3ConnectionException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class S3ImageService implements S3ServiceContract
{
    private const FILE_TYPE = '.webp';


    public static function uploadFile(string $fileId, UploadedFile $file)
    {
        $fileName = $fileId . self::FILE_TYPE;

        try {
            Storage::disk('s3')->put($fileName, $file->get());
        } catch (\Exception $e) {
            Log::error("Failed to upload from S3:" . $e->getMessage());
            throw new S3ConnectionException("Failed to upload file to S3");
        }
    }

    public static  function  deleteFile(string|null $fileId)
    {
        $fileName = $fileId . self::FILE_TYPE;

        if (!Storage::disk('s3')->exists($fileName) || !$fileId) {
            return;
        }

        try {
            Storage::disk('s3')->delete($fileName);
        } catch (\Exception $e) {
            Log::error("Failed to delete from S3:" . $e->getMessage());
            throw new S3ConnectionException("Failed to delete file to S3");
        }
    }
}
