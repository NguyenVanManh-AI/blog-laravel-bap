<?php

namespace App\Repositories;

use App\Models\Notify;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class ExampleRepository.
 */
class NotifyRepository extends BaseRepository implements NotifyInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function getModel()
    {
        return Notify::class;
    }

    /**
     * addNotify
     *
     * @param object $input
     */
    public static function addNotify($input)
    {
        DB::beginTransaction();
        try {
            $newNotify = (new self)->model->create([
                'id_user' => $input->to,
                'id_from' => $input->from,
                'id_article' => $input->id_article,
                'is_like' => $input->is_like,
            ]);
            DB::commit();

            return $newNotify;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * getNotify
     *
     * @param object $input
     */
    public static function findNotify($input)
    {
        return (new self)->model->where('id_user', '=', $input->to)
            ->where('id_from', '=', $input->from)
            ->where('id_article', '=', $input->id_article)
            ->where('is_like', '=', $input->is_like)
            ->first();
    }

    /**
     * getAllNotify
     *
     * @param int $id
     * @return object
     */
    public static function getAllNotify($id)
    {
        return (new self)->model->join('users', 'notifies.id_from', '=', 'users.id')
            ->join('articles', 'notifies.id_article', '=', 'articles.id')
            ->select('users.name', 'users.avatar', 'articles.id as id_article', 'articles.title', 'notifies.is_like', 'notifies.created_at', 'notifies.id as id_notify')
            ->where('notifies.id_user', '=', $id)
            ->orderBy('notifies.id', 'desc')->get();
    }

    /**
     * findNotifyById
     *
     * @param int $id
     * @return object
     */
    public static function findNotifyById($id)
    {
        return (new self)->model->find($id);
    }

    /**
     * getAllNotifyStatic
     *
     * @return array
     */
    public static function getAllNotifyStatic()
    {
        return (new self)->model->all();
    }

    /**
     * deleteNotify
     *
     * @param int $idArticle
     * @return object
     */
    public static function deleteNotify($idArticle)
    {
        DB::beginTransaction();
        try {
            (new self)->model->where('id_article', $idArticle)->delete();
            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
