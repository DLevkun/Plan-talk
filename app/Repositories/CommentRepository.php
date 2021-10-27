<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository
{
    public function getComment($id){
        $comment = Comment::find($id);
        return $comment;
    }
}
