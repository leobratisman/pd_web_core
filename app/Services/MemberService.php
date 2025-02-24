<?php

namespace App\Services;

use App\Models\Member;
use App\Services\S3\S3ImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class MemberService
{
    public function uploadImage(UploadedFile $file, Member $member)
    {
        $uuid = Str::uuid();
        S3ImageService::uploadFile(fileId: $uuid, file: $file);

        $member->update([
            'image_id' => $uuid
        ]);
        $member->refresh();
    }
}
