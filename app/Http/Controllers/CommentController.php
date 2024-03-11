<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Services\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * getTitle
     *
     * @param string $title_main
     * @param string $title_sub
     * @return array
     */
    public function getTitle($titleMain, $titleSub)
    {
        $title['title_main'] = $titleMain;
        $title['title_sub'] = $titleSub;

        return $title;
    }

    /**
     * viewMain
     *
     * @return view
     */
    public function viewMain()
    {
        $articles = $this->commentService->getAllArticle();
        $notifys = null;
        if (auth()->guard('user')->check()) {
            $notifys = $this->commentService->getAllNotify(auth()->guard('user')->user()->id);
        }

        return view('blog.main.main', ['articles' => $articles, 'notifys' => $notifys]);
    }

    /**
     * updateComment
     *
     * @param Request $request
     * @return response
     */
    public function updateComment(Request $request)
    {
        $newCommment = (object) [
            'id' => $request->id_comment ?? '',
            'content' => $request->new_content_comment ?? '',
        ];
        $status = $this->commentService->updateComment($newCommment);

        return response()->json(['status' => $status]);
    }

    /**
     * deleteComment
     *
     * @param Request $request
     * @return response
     */
    public function deleteComment(Request $request)
    {
        $idComment = $request->id_comment ?? '';
        $status = $this->commentService->deleteComment($idComment);

        return response()->json(['status' => $status]);
    }

    /**
     * deleteCommentAdmin
     *
     * @param Request $request
     */
    public function deleteCommentAdmin($idComment)
    {
        $this->commentService->deleteComment($idComment);

        return redirect()->back();
    }

    /**
     * addComment
     *
     * @param Request $request
     * @return object
     */
    public function addComment(Request $request)
    {
        $user = Auth::guard('user')->user();
        $newCommment = (object) [
            'id_user' => $user->id,
            'id_article' => $request->id_article,
            'content' => $request->new_content_comment,
        ];
        $commentElement = $this->commentService->addComment($newCommment, $user);

        return response()->json([
            'comment_element' => $commentElement,
        ]);
    }

    /**
     * searchLeft
     *
     * @param Request $request
     * @return response
     */
    public function searchLeft(Request $request)
    {
        $resultSearch = $this->commentService->searchLeft($request->search_text);

        return response()->json([
            'result_search' => $resultSearch,
        ]);
    }

    /**
     * personalPage
     *
     * @param int $id_user
     * @return view
     */
    public function personalPage($idUser)
    {
        $output = $this->commentService->personalPage($idUser);
        $notifys = null;
        if (auth()->guard('user')->check()) {
            $notifys = $this->commentService->getAllNotify(auth()->guard('user')->user()->id);
        }

        return view('blog.main.personal_page', ['articles' => $output['articles'], 'personal' => $output['personal'], 'notifys' => $notifys]);
    }

    /**
     * articleDetails
     *
     * @param int $id_article
     * @return view
     */
    public function articleDetails($idArticle)
    {
        $articles = $this->commentService->articleDetails($idArticle);
        $notifys = null;
        if (auth()->guard('user')->check()) {
            $notifys = $this->commentService->getAllNotify(auth()->guard('user')->user()->id);
        }

        return view('blog.main.article_details', ['articles' => $articles, 'notifys' => $notifys]);
    }

    /**
     * allCommentAdmin
     *
     * @return view
     */
    public function allCommentAdmin()
    {
        $comments = $this->commentService->allCommentAdmin();

        return view('admin.manage.comment', ['comments' => $comments, 'title' => $this->getTitle('Comments', 'All Comments')]);
    }

    /**
     * ajaxSearchCmtAdmin
     *
     * @param Request $request
     * @return object
     */
    public function ajaxSearchCmtAdmin(Request $request)
    {
        return $this->commentService->ajaxSearchCmtAdmin($request->search);
    }
}
