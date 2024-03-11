<?php

namespace App\Services;

use App\Events\PusherBroadcast;
use App\Repositories\ArticleRepository;
use App\Repositories\LikedInterface;
use App\Repositories\NotifyRepository;
use App\Repositories\UserRepository;

class LikedService
{
    protected LikedInterface $likedRepository;

    /**
     * __construct
     */
    public function __construct(
        LikedInterface $likedRepository
    ) {
        $this->likedRepository = $likedRepository;
    }

    /**
     * likeArticle
     *
     * @param object $input
     */
    public function likeArticle($input)
    {
        try {
            $liked = $this->likedRepository->getLiked($input->id_article);
            $_idUser = $input->id_user;
            $id_article = $input->id_article;
            if ($input->is_like == 0) {
                if ($liked) {
                    $id_users = json_decode($liked->id_users);
                    $index = array_search($input->id_user, $id_users);
                    if ($index !== false) {
                        unset($id_users[$index]);
                        $id_users = array_values($id_users);
                    }

                    if (count($id_users) == 0) {
                        $liked->delete();
                    } else {
                        $liked->update([
                            'id_users' => json_encode($id_users),
                        ]);
                    }

                    // notify
                    $articleNoti = ArticleRepository::getArticle($id_article);
                    $user = auth()->guard('user')->user();
                    if ($user->id != $articleNoti->id_user) {
                        $input = (object) [
                            'id_article' => $articleNoti->id,
                            'from' => $user->id,
                            'to' => $articleNoti->id_user,
                            'is_like' => 1,
                        ];
                        $notify = NotifyRepository::findNotify($input);
                        if ($notify) {
                            $this->broadcastUnLike($articleNoti->id, $user->id, $input->is_like, $notify->id);
                            $notify->delete();
                        }
                    }
                    // notify
                }
            } else {
                if ($liked) {
                    $id_users = json_decode($liked->id_users);

                    if (!in_array($input->id_user, $id_users)) {
                        $id_users[] = $input->id_user; // add $is_user to array
                        $liked->update([
                            'id_users' => json_encode($id_users),
                        ]);
                    }
                } else {
                    $id_users = [$input->id_user];
                    $new_liked = [
                        'id_users' => json_encode($id_users),
                        'id_article' => $input->id_article,
                    ];
                    $this->likedRepository->creatLiked($new_liked);
                }
                $renderHtml = view('blog.render_ajax.user_like', compact('id_article'))->render();

                // notify
                $articleNoti = ArticleRepository::getArticle($id_article);
                $user = auth()->guard('user')->user();
                if ($user->id != $articleNoti->id_user) {
                    $input = (object) [
                        'id_article' => $articleNoti->id,
                        'from' => $user->id,
                        'to' => $articleNoti->id_user,
                        'is_like' => 1,
                    ];
                    $notify = NotifyRepository::findNotify($input);
                    if (empty($notify)) {
                        $newNotify = NotifyRepository::addNotify($input);
                        $this->broadcastAddCmtLike($articleNoti->id, $user->id, $input->is_like, $newNotify->id);
                    }
                }
                // notify

                return response()->json([
                    'id_user' => $_idUser,
                    'id_article' => $input->id_article,
                    'is_like' => $input->is_like,
                    'render_html' => $renderHtml,
                ]);
            }
        } catch (\Exception $e) {
        }
    }

    /**
     * listLike
     *
     * @param int $id_article
     */
    public function listLike($idArticle)
    {
        try {
            $liked = $this->likedRepository->getLiked($idArticle);
            if ($liked) {
                $users = UserRepository::getListUser(json_decode($liked->id_users));
            } else {
                $users = null;
            }
            $renderHtml = view('blog.render_ajax.list_like', compact('users'))->render();

            return response()->json([
                'render_html' => $renderHtml,
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

    /**
     * broadcastUnLike
     *
     * @param int $idArticle
     * @param int $idUser
     */
    public function broadcastUnLike($idArticle, $idUser, $is_like, $id_notify)
    {
        try {
            $article = ArticleRepository::getArticle($idArticle);
            broadcast(new PusherBroadcast([
                'id_article' => $article->id,
                'to' => $article->id_user,
                'from' => $idUser,
                'is_like' => $is_like,
                'id_notify' => $id_notify,
                'notify' => 'un_like',
            ]))->toOthers();
        } catch (\Exception $e) {
        }
    }
}
