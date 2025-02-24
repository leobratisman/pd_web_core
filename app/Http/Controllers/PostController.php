<?php

namespace App\Http\Controllers;

use App\Exceptions\S3ConnectionException;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Requests\UploadImageRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use App\Services\S3\S3ImageService;
use Illuminate\Http\Request;

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
        $this->deleteImage($post);
        $post->delete();

        return response()->noContent();
    }

    public function uploadImage(
        UploadImageRequest $request,
        Post $post,
        PostService $postService
    )
    {
        $data = $request->validated();
        if (!is_null($post->image_id)) {
            $this->deleteImage($post);
        }

        $postService->uploadImage(file: $data['image'], post: $post);
    }

    public function deleteImage(Post $post)
    {
        try {
            S3ImageService::deleteFile(fileId: $post->image_id);
        } catch (S3ConnectionException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }

        $post->update([
            'image_id' => null
        ]);
        $post->refresh();
    }
}
