<?php

namespace App\Http\Controllers;

use App\Exceptions\S3ConnectionException;
use App\Http\Requests\Member\StoreRequest;
use App\Http\Requests\Member\UpdateRequest;
use App\Http\Requests\UploadImageRequest;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use App\Services\MemberService;
use App\Services\S3\S3ImageService;
use Illuminate\Http\Request;

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
        $this->deleteImage($member);
        $member->delete();

        return response()->noContent();
    }

    public function uploadImage(
        UploadImageRequest $request,
        Member $member,
        MemberService $memberService
    )
    {
        $data = $request->validated();
        if (!is_null($member->image_id)) {
            $this->deleteImage($member);
        }

        $memberService->uploadImage(file: $data['image'], member: $member);
    }

    public function deleteImage(Member $member)
    {
        try {
            S3ImageService::deleteFile(fileId: $member->image_id);
        } catch (S3ConnectionException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }

        $member->update([
            'image_id' => null
        ]);
        $member->refresh();
    }
}
