<?php

namespace App\Repositories;

use App\Models\Comment;
use Illuminate\Support\Facades\Cache;

class CommentRepository
{
    public function getComment($id){
        $comment = Comment::find($id);
        return $comment;
    }
}
