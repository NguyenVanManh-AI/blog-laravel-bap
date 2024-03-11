<?php

namespace App\Repositories;

use App\Models\Liked;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class ExampleRepository.
 */
class LikedRepository extends BaseRepository implements LikedInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function getModel()
    {
        return Liked::class;
    }

    /**
     * getLiked
     *
     * @param int $id_article
     * @return object
     */
    public function getLiked($idArticle)
    {
        return $this->model->where('id_article', $idArticle)->first();
    }

    /**
     * creatLiked
     *
     * @param object $new_liked
     */
    public function creatLiked($newLiked)
    {
        DB::beginTransaction();
        try {
            $liked = $this->model->create($newLiked);
            DB::commit();

            return $liked;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * deleteLiked
     *
     * @param int $id_article
     */
    public static function deleteLiked($idArticle)
    {
        DB::beginTransaction();
        try {
            (new self)->model->where('id_article', $idArticle)->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
