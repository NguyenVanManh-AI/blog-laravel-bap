<?php

namespace App\Services;

use App\Events\PusherBroadcast;
use App\Models\User;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentInterface;
use App\Repositories\CommentRepository;
use App\Repositories\NotifyRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Cache;

class CommentService
{
    protected CommentInterface $commentRepository;

    /**
     * __construct
     */
    public function __construct(
        CommentInterface $commentRepository
    ) {
        $this->commentRepository = $commentRepository;
    }

    /**
     * getAllArticle
     *
     * @return object
     */
    public function getAllArticle()
    {
        // $articles = Cache::remember('articles', 60, function () {
        //     return ArticleRepository::getAllArticleMain()->paginate(2);
        // });
        $articles = ArticleRepository::getAllArticleMain()->paginate(6);
        foreach ($articles as $article) {
            $comments = $this->commentRepository->getComment($article->id_article);
            $article->comments = $comments;
            if (isset($article->user_likes)) {
                $article->arr_user_likes = UserRepository::getListUser(json_decode($article->user_likes));
            }
        }

        return $articles;
    }

    /**
     * updateComment
     *
     * @param string $new_commment
     * @return bool
     */
    public function updateComment($new_commment)
    {
        try {
            return $this->commentRepository->updateComment($new_commment);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * deleteComment
     *
     * @param int $id_comment
     * @return bool
     */
    public function deleteComment($id_comment)
    {
        try {
            return $this->commentRepository->deleteComment($id_comment);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * addComment
     *
     * @param object $new_commment
     * @param object $user
     * @return bool
     */
    public function addComment($newCommment, $user)
    {
        try {
            $article = ArticleRepository::getArticle($newCommment->id_article);
            $comment = $this->commentRepository->addComment($newCommment);
            if ($user->id != $article->id_user) {
                $input = (object) [
                    'id_article' => $article->id,
                    'from' => $user->id,
                    'to' => $article->id_user,
                    'is_like' => 0,
                ];
                $notify = NotifyRepository::findNotify($input);
                if (empty($notify)) {
                    $newNotify = NotifyRepository::addNotify($input);
                    $this->broadcastAddCmtLike($article->id, $user->id, $input->is_like, $newNotify->id);
                }
            }

            return view('blog.render_ajax.new_comment', compact('article', 'comment', 'user'))->render();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * searchLeft
     *
     * @param string $search_text
     * @return view
     */
    public function searchLeft($search_text)
    {
        try {
            $search_user = null;
            $search_article = null;
            $search_text = $search_text;
            $search_user = UserRepository::searchUser($search_text);
            $n = count($search_user);
            if ($n < 10) {
                $search_article = ArticleRepository::searchArticle($search_text, $n);
            }

            return view('blog.render_ajax.search_left', compact('search_article', 'search_user'))->render();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * personalPage
     *
     * @param int $id_user
     * @return array
     */
    public function personalPage($id_user)
    {
        try {
            $personal = UserRepository::findUserById($id_user);
            $articles = ArticleRepository::personalPage($personal->id)->paginate(6);
            foreach ($articles as $article) {
                $comments = $this->commentRepository->personalPage($article->id_article);
                $article->comments = $comments;
                if (isset($article->user_likes)) {
                    $article->arr_user_likes = UserRepository::getListUser(json_decode($article->user_likes));
                }
            }

            return ['personal' => $personal, 'articles' => $articles];
        } catch (\Exception $e) {
        }
    }

    /**
     * articleDetails
     *
     * @param int $id_article
     * @return object
     */
    public function articleDetails($id_article)
    {
        try {
            $articles = ArticleRepository::articleDetails($id_article);
            foreach ($articles as $article) {
                $comments = CommentRepository::articleDetails($article->id_article);
                $article->comments = $comments;
                if (isset($article->user_likes)) {
                    $article->arr_user_likes = UserRepository::getListUser(json_decode($article->user_likes));
                }
            }

            return $articles;
        } catch (\Exception $e) {
        }
    }

    /**
     * allCommentAdmin
     *
     * @return array
     */
    public function allCommentAdmin()
    {
        try {
            return $this->commentRepository->getAllComment()->paginate(6);
        } catch (\Exception $e) {
        }
    }

    /**
     * ajaxSearchCmtAdmin
     *
     * @param string $search_text
     * @return response
     */
    public function ajaxSearchCmtAdmin($searchText)
    {
        try {
            $comments = $this->commentRepository->ajaxSearch($searchText)->paginate(6);
            $renderHtml = view('admin.render_ajax.search_all_cmt', compact('comments'))->render();
            $pagination = $comments->links()->toHtml();

            return response()->json([
                'render_html' => $renderHtml,
                'pagination' => $pagination,
            ]);
        } catch (\Exception $e) {
        }
    }

    /**
     * broadcastAddCmtLike
     *
     * @param int $idArticle
     * @param int $idUser
     */
    public function broadcastAddCmtLike($idArticle, $idUser, $is_like, $id_notify)
    {
        try {
            $article = ArticleRepository::getArticle($idArticle);
            broadcast(new PusherBroadcast([
                'id_article' => $article->id,
                'to' => $article->id_user,
                'from' => $idUser,
                'is_like' => $is_like,
                'id_notify' => $id_notify,
                'notify' => 'add_cmt_like',
            ]))->toOthers();
        } catch (\Exception $e) {
        }
    }

    public function getAllNotify($id)
    {
        try {
            return NotifyRepository::getAllNotify($id);
        } catch (\Exception $e) {
        }
    }
}
