<?php

namespace App\Http\Controllers;

use App\Services\NotifyService;
use Illuminate\Http\Request;

class NotifyController extends Controller
{
    protected NotifyService $notifyService;

    public function __construct(NotifyService $notifyService)
    {
        $this->notifyService = $notifyService;
    }

    /**
     * receiveAddCmtLike
     *
     * @param Request $request
     * @return json
     */
    public function receiveAddCmtLike(Request $request)
    {
        $input = (object) [
            'id_article' => $request->id_article,
            'from' => $request->from,
            'to' => $request->to,
            'is_like' => $request->is_like,
            'id_notify' => $request->id_notify,
        ];

        return $this->notifyService->receiveAddCmtLike($input);
    }

    /**
     * deleteNotify
     *
     * @param Request $request
     */
    public function deleteNotify(Request $request)
    {
        return $this->notifyService->deleteNotify($request->id_notify);
    }
}
