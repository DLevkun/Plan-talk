<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentPublishRequest;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ChecksIsDataSecure;

class CommentController extends Controller
{
    use ChecksIsDataSecure;

    private $commentRepository;

    public function __construct()
    {
        $this->commentRepository = new CommentRepository();
    }

    /**
     * Create comment for post
     * @param CommentPublishRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function comment(CommentPublishRequest $request, $id)
    {
        $comment = new Comment;
        $comment->post_id = $id;
        $comment->comment = $this->getSecureData($request->input('comment'));
        $comment->user_id = Auth::user()->id;
        $comment->save();

        return back();
    }

    /**
     * Delete comment
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteComment($id){
        $this->commentRepository->getOneById($id)->delete();
        return redirect()->back();
    }
}
