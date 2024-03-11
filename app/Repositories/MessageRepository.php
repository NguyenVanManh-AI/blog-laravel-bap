<?php

namespace App\Repositories;

use App\Models\Message;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class ExampleRepository.
 */
class MessageRepository extends BaseRepository implements MessageInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function getModel()
    {
        return Message::class;
    }

    /**
     * getAllMessageStatic
     *
     * @return array
     */
    public static function getAllMessageStatic()
    {
        return (new self)->model->all();
    }

    /**
     * getListMessages
     *
     * @param object $user
     * @param int $id_to
     * @return object
     */
    public function getListMessages($user, $id_to)
    {
        return $this->model->join('users', 'users.id', '=', 'messages.id_from')
            ->where(function ($query) use ($user, $id_to) {
                $query->where('messages.id_from', $user->id)
                    ->where('messages.id_to', $id_to);
            })
            ->orWhere(function ($query) use ($user, $id_to) {
                $query->where('messages.id_from', $id_to)
                    ->where('messages.id_to', $user->id);
            })
            ->select('messages.*', 'users.*', 'messages.id as id_message', 'users.id  as id_user')
            ->orderBy('messages.id')
            ->get();
    }

    /**
     * getListUsers
     *
     * @param int $id
     * @return object
     */
    public function getListUsers($id)
    {
        $messagesFrom = $this->model->where('id_to', $id)->distinct('id_from')->pluck('id_from');
        $messagesTo = $this->model->where('id_from', $id)->distinct('id_to')->pluck('id_to');
        $relatedUserIds = $messagesFrom->concat($messagesTo)->unique();
        $relatedUsers = UserRepository::getListUsers($relatedUserIds);

        return $relatedUsers;
    }

    /**
     * getMessageViewChat
     *
     * @param object $user
     * @param object $_user
     * @return object
     */
    public function getMessageViewChat($user, $_user)
    {
        return $this->model->where(function ($query) use ($user, $_user) {
            $query->where('messages.id_from', $user->id)
                ->where('messages.id_to', $_user->id);
        })
            ->orWhere(function ($query) use ($user, $_user) {
                $query->where('messages.id_from', $_user->id)
                    ->where('messages.id_to', $user->id);
            })
            ->orderBy('id', 'desc')
            ->latest()
            ->first();
    }

    /**
     * findMessageById
     *
     * @param int $id
     * @return object
     */
    public function findMessageById($id)
    {
        return $this->model->find($id);
    }

    /**
     * createMessage
     *
     * @param array $input
     * @return object
     */
    public function createMessage($input)
    {
        DB::beginTransaction();
        try {
            $newMessage = $this->model->create($input);
            DB::commit();

            return $newMessage;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
