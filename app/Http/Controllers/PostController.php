<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Requests\UploadImageRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\S3\S3ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return PostResource::collection($posts);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $member = Post::create($data);

        return PostResource::make($member);
    }

    public function show(Post $post)
    {
        return PostResource::make($post);
    }

    public function update(UpdateRequest $request, Post $post)
    {
        $data = $request->validated();
        $post->update($data);

        return PostResource::make($post->refresh());
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->noContent();
    }

    public function uploadImage(UploadImageRequest $request, Post $post)
    {
        if (!is_null($post->image_id)) {
            $this->deleteImage($post);
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

        $post->update([
            'image_id' => $uuid
        ]);
        $post->refresh();
    }

    public function deleteImage(Post $post)
    {
        if (!$post->image_id) {
            return response()->json([
                'message' => 'Nothing to delete'
            ], 404);
        }
        S3ImageService::deleteFile(fileId: $post->image_id);
        $post->update([
            'image_id' => null
        ]);
        $post->refresh();
    }
}
