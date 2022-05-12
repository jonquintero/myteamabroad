<?php

namespace App\Actions;

use App\DataTransferObjects\PostData;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;


class UpsertPostAction
{
    public function execute(Post $post, PostData $postData): Post
    {
        $post->title = $postData->title;
        $post->description = $postData->description;
        $post->user_id = Auth::id();
        $post->save();

        return $post;
    }
}
