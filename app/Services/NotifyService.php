<?php

namespace App\Services;

use App\Repositories\ArticleRepository;
use App\Repositories\NotifyInterface;
use App\Repositories\NotifyRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class NotifyService
{
    protected NotifyInterface $notifyRepository;

    /**
     * __construct
     */
    public function __construct(
        NotifyInterface $notifyRepository
    ) {
        $this->notifyRepository = $notifyRepository;
    }

    /**
     * receiveAddCmt
     *
     * @param Request $request
     * @return json
     */
    public function receiveAddCmtLike($input)
    {
        try {
            $is_like = $input->is_like;
            $id_notify = $input->id_notify;
            if ($input->to == auth()->guard('user')->user()->id) {
                $user = UserRepository::findUserById($input->from);
                $article = ArticleRepository::getArticle($input->id_article);
                $message = view('blog.render_ajax.notify_cmt_like', compact('user', 'article', 'is_like', 'id_notify'))->render();
                $response = [
                    'status' => true,
                    'message' => $message,
                ];

                return response()->json($response);
            } else {
                $response = [
                    'status' => false,
                    'message' => '1',
                ];

                return response()->json($response);
            }
        } catch (\Exception $e) {
        }
    }

    /**
     * receiveAddCmt
     *
     * @param Request $request
     * @return json
     */
    public function deleteNotify($id_notify)
    {
        try {
            $notify = NotifyRepository::findNotifyById($id_notify);
            if ($notify) {
                $notify->delete();
            }
            $response = [
                'status' => true,
            ];

            return response()->json($response);
        } catch (\Exception $e) {
        }
    }
}
