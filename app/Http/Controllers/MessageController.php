<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected MessageService $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
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
     * viewChat
     *
     * @param Request $request
     * @param int $id
     * @return object
     */
    public function viewChat(Request $request, $id)
    {
        return $this->messageService->viewChat($id);
    }

    /**
     * deleteMessage
     *
     * @param Request $request
     * @return object
     */
    public function deleteMessage(Request $request)
    {
        return $this->messageService->deleteMessage($request);
    }

    /**
     * addMessage
     *
     * @param Request $request
     * @return object
     */
    public function addMessage(Request $request)
    {
        return $this->messageService->addMessage($request);
    }

    /**
     * realtimeAddMessage
     *
     * @param Request $request
     * @return object
     */
    public function realtimeAddMessage(Request $request)
    {
        return $this->messageService->realtimeAddMessage($request);
    }

    /**
     * realtimeDelMessage
     *
     * @param Request $request
     * @return object
     */
    public function realtimeDelMessage(Request $request)
    {
        return $this->messageService->realtimeDelMessage($request);
    }

    /**
     * searchLeft
     *
     * @param Request $request
     * @return response
     */
    public function searchLeft(Request $request)
    {
        $resultSearch = $this->messageService->searchLeft($request->search_text);

        return response()->json([
            'result_search' => $resultSearch,
        ]);
    }
}
