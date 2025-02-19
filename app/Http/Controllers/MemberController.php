<?php

namespace App\Http\Controllers;

use App\Http\Requests\Member\StoreRequest;
use App\Http\Requests\Member\UpdateRequest;
use App\Http\Requests\UploadImageRequest;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use App\Services\S3\S3ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();
        return MemberResource::collection($members);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $member = Member::create($data);

        return MemberResource::make($member);
    }

    public function show(Member $member)
    {
        return MemberResource::make($member);
    }

    public function update(UpdateRequest $request, Member $member)
    {
        $data = $request->validated();
        $member->update($data);

        return MemberResource::make($member->refresh());
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return response()->noContent();
    }

    public function uploadImage(UploadImageRequest $request, Member $member)
    {
        if (!is_null($member->image_id)) {
            $this->deleteImage($member);
        }
        $uuid = Str::uuid();
        $image = $request->file('image');

        try {
            S3ImageService::uploadFile(fileId: $uuid, file: $image);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to upload image'
            ], 500);
        }

        $member->update([
            'image_id' => $uuid
        ]);
        $member->refresh();
    }

    public function deleteImage(Member $member)
    {
        if (!$member->image_id) {
            return response()->json([
                'message' => 'Nothing to delete'
            ], 404);
        }
        S3ImageService::deleteFile(fileId: $member->image_id);
        $member->update([
            'image_id' => null
        ]);
        $member->refresh();
    }
}
