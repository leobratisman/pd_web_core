<?php

namespace App\Services;

use App\Models\Post;
use App\Services\S3\S3ImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class PostService
{
    public function uploadImage(UploadedFile $file, Post $post)
    {
        $uuid = Str::uuid();
        S3ImageService::uploadFile(fileId: $uuid, file: $file);

        $post->update([
            'image_id' => $uuid
        ]);
        $post->refresh();
    }
}
