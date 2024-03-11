<?php

namespace App\Services;

use App\Events\PusherBroadcast;
use App\Repositories\MessageInterface;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;

class MessageService
{
    protected MessageInterface $messageRepository;

    /**
     * __construct
     */
    public function __construct(
        MessageInterface $messageRepository
    ) {
        $this->messageRepository = $messageRepository;
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
     * searchLeft
     *
     * @param string $search_text
     * @return view
     */
    public function searchLeft($search_text)
    {
        try {
            $search_user = null;
            $search_text = $search_text;
            $search_user = UserRepository::searchUser($search_text);

            return view('blog.render_ajax.search_left_chat', compact('search_user'))->render();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * viewChat
     *
     * @param int $id
     * @return object
     */
    public function viewChat($id)
    {
        try {
            $user = auth()->guard('user')->user();
            $idTo = $id;
            $listMessages = $this->messageRepository->getListMessages($user, $idTo);
            $userTo = UserRepository::findUserById($idTo);
            $listUsers = $this->messageRepository->getListUsers($user->id);
            foreach ($listUsers as $_user) {
                $message = $this->messageRepository->getMessageViewChat($user, $_user);
                if ($message) {
                    $_user->content = $message->content;
                    $_user->id_from_content = $message->id_from;
                    $_user->id__message = $message->id;
                } else {
                    $_user->content = '&&like&&';
                    $_user->id_from_content = $message->id_from;
                    $_user->id__message = $message->id;
                }
            }
            $listUsers = $listUsers->sortByDesc('id__message')->values()->all();

            return view('blog.chat.chat_frame', ['title' => $this->getTitle('Chat', $userTo->name), 'listMessages' => $listMessages, 'user_to' => $userTo, 'listUsers' => $listUsers]);
        } catch (\Exception $e) {
        }
    }

    /**
     * deleteMessage
     *
     * @param Request $request
     * @return object
     */
    public function deleteMessage(Request $request)
    {
        try {
            $idMessage = $request->id_message;
            $message = $this->messageRepository->findMessageById($idMessage);
            $idFrom = $message->id_from;
            $idTo = $message->id_to;
            if ($message) {
                $message->delete();
            }
            // realtime
            broadcast(new PusherBroadcast([
                'id_message' => $idMessage,
                'id_from' => $idFrom,
                'id_to' => $idTo,
                'notify' => 'delete_message',
            ]))->toOthers();
            // realtime
            return response()->json([
                'id_message' => $idMessage,
                'id_from' => $idFrom,
                'id_to' => $idTo,
            ]);
        } catch (\Exception $e) {
        }
    }

    /**
     * addMessage
     *
     * @param Request $request
     * @return object
     */
    public function addMessage(Request $request)
    {
        try {
            $idTo = $request->id_to;
            $idFrom = $request->id_from;
            $newContentMessage = $request->new_content_message;
            $input = [
                'id_from' => $idFrom,
                'id_to' => $idTo,
                'content' => $newContentMessage,
            ];
            $new_message = $this->messageRepository->createMessage($input);
            $newMessageHtml = view('blog.render_ajax.new_message_from', compact('new_message'))->render();
            // realtime
            broadcast(new PusherBroadcast([
                'id_new_message' => $new_message->id,
                'id_from' => $idFrom,
                'notify' => 'add_message',
            ]))->toOthers();
            // realtime

            return response()->json([
                'status' => true,
                'new_message_html' => $newMessageHtml,
            ]);
        } catch (\Exception $e) {
        }
    }

    /**
     * realtimeAddMessage
     *
     * @param Request $request
     * @return object
     */
    public function realtimeAddMessage(Request $request)
    {
        try {
            $idNewMessage = $request->id_new_message;
            $new_message = $this->messageRepository->findMessageById($idNewMessage);
            if ($new_message->id_to == auth()->guard('user')->user()->id) {
                $user_from = UserRepository::findUserById($new_message->id_from);
                $user_to = UserRepository::findUserById($new_message->id_to);
                $newMessageHtml = view('blog.render_ajax.new_message_to', compact('user_from', 'user_to', 'new_message'))->render();
                $chattingNewHtml = view('blog.render_ajax.chatting_new', compact('user_from', 'new_message'))->render();
                $response = [
                    'status' => true,
                    'id_from' => $new_message->id_from,
                    'new_message_html' => $newMessageHtml,
                    'chatting_new_html' => $chattingNewHtml,
                    'id_message' => $new_message->id,
                ];

                return response()->json($response);
            } elseif ($new_message->id_from == auth()->guard('user')->user()->id) {
                $user_to = UserRepository::findUserById($new_message->id_from);
                $user_from = UserRepository::findUserById($new_message->id_to);
                $chattingNewHtml = view('blog.render_ajax.chatting_new', compact('user_from', 'new_message'))->render();
                $newMessageHtml = view('blog.render_ajax.new_message_from', compact('new_message'))->render();
                $response = [
                    'status' => true,
                    'id_from' => $new_message->id_to,
                    'new_message_html' => $newMessageHtml,
                    'chatting_new_html' => $chattingNewHtml,
                    'id_message' => $new_message->id,
                ];

                return response()->json($response);
            } else {
                $response = [
                    'status' => false,
                    'new_message_html' => '1',
                ];

                return response()->json($response);
            }
        } catch (\Exception $e) {
        }
    }

    /**
     * realtimeDelMessage
     *
     * @param Request $request
     * @return object
     */
    public function realtimeDelMessage(Request $request)
    {
        try {
            $idTo = $request->id_to;
            $id_from = $request->id_from;
            if ($idTo == auth()->guard('user')->user()->id) {
                $user_from = UserRepository::findUserById($id_from);
                $user_to = UserRepository::findUserById($idTo);
                $chatting_delete_html = view('blog.render_ajax.chatting_delete', compact('id_from', 'user_from'))->render();
                $response = [
                    'status' => true,
                    'id_from' => $id_from,
                    'chatting_delete_html' => $chatting_delete_html,
                ];

                return response()->json($response);
            } elseif ($id_from == auth()->guard('user')->user()->id) {
                $user_to = UserRepository::findUserById($id_from);
                $user_from = UserRepository::findUserById($idTo);
                $chatting_delete_html = view('blog.render_ajax.chatting_delete', compact('id_from', 'user_from'))->render();
                $response = [
                    'status' => true,
                    'id_from' => $idTo,
                    'chatting_delete_html' => $chatting_delete_html,
                ];

                return response()->json($response);
            } else {
                $response = [
                    'status' => false,
                    'new_message_html' => '1',
                ];

                return response()->json($response);
            }
        } catch (\Exception $e) {
        }
    }
}
