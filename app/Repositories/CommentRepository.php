<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository implements Repository
{
    /**
     * Get comment by its id
     * @param $id
     * @return mixed
     */
    public function getOneById($id){
        $comment = Comment::find($id);
        return $comment;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getAllByUser($user)
    {
        // TODO: Implement getAllByUser() method.
    }

    /**
     * @codeCoverageIgnore
     */
    public function getAll()
    {
        // TODO: Implement getAll() method.
    }
}
