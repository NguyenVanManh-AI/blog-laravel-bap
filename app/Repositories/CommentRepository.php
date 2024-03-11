<?php

namespace App\Repositories;

use App\Models\Comment;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class ExampleRepository.
 */
class CommentRepository extends BaseRepository implements CommentInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function getModel()
    {
        return Comment::class;
    }

    /**
     * deleteCommentArticle
     *
     * @param int $id_article
     */
    public static function deleteCommentArticle($idArticle)
    {
        DB::beginTransaction();
        try {
            (new self)->model
                ->when($idArticle, fn ($q) => $q->where('id_article', '=', $idArticle))
                ->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * getComment
     *
     * @param int $id_article
     * @return object
     */
    public function getComment($idArticle)
    {
        return $this->model->where('id_article', $idArticle)
            ->join('users', 'users.id', '=', 'comments.id_user')
            ->select('comments.*', 'users.*', 'comments.id as id_comment', 'users.id as id_user')
            ->where('users.status', '!=', 0)
            ->orderBy('comments.id', 'DESC')
            ->get();
    }

    /**
     * updateComment
     *
     * @param object $new_comment
     * @return bool
     */
    public function updateComment($newComment)
    {
        DB::beginTransaction();
        try {
            $comment = $this->model->where('id', $newComment->id)->first();
            $comment->update(['content' => $newComment->content]);
            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * deleteComment
     *
     * @param int $id_comment
     * @return bool
     */
    public function deleteComment($idComment)
    {
        DB::beginTransaction();
        try {
            $this->model->where('id', $idComment)->first()->delete();
            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * addComment
     *
     * @param object $new_comment
     * @return object
     */
    public function addComment($newComment)
    {
        DB::beginTransaction();
        try {
            $newCmt = $this->model->create([
                'id_user' => $newComment->id_user,
                'id_article' => $newComment->id_article,
                'content' => $newComment->content,
            ]);
            DB::commit();

            return $newCmt;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * personalPage
     *
     * @param int $id_article
     * @return object
     */
    public function personalPage($idArticle)
    {
        return $this->model->where('id_article', $idArticle)
            ->join('users', 'users.id', '=', 'comments.id_user')
            ->select('comments.*', 'users.*', 'comments.id as id_comment', 'users.id as id_user')
            ->orderBy('comments.id', 'DESC')
            ->get();
    }

    /**
     * articleDetails
     *
     * @param int $id_article
     * @return object
     */
    public static function articleDetails($idArticle)
    {
        return (new self)->model->where('id_article', $idArticle)
            ->join('users', 'users.id', '=', 'comments.id_user')
            ->select('comments.*', 'users.*', 'comments.id as id_comment', 'users.id as id_user')
            ->orderBy('comments.id', 'DESC')
            ->get();
    }

    /**
     * getAllComment
     *
     * @return array
     */
    public function getAllComment()
    {
        return $this->model->join('users', 'comments.id_user', '=', 'users.id')
            ->select('comments.*', 'users.name')
            ->orderBy('comments.id', 'desc');
    }

    /**
     * ajaxSearch
     *
     * @param string $search_text
     * @return object
     */
    public function ajaxSearch($searchText)
    {
        return $this->model->join('users', 'comments.id_user', '=', 'users.id')
            ->select('comments.*', 'users.name')
            ->where('comments.content', 'like', '%' . $searchText . '%')
            ->orWhere('users.name', 'like', '%' . $searchText . '%')
            ->orderBy('comments.id', 'desc');
    }

    /**
     * getYearlyStatsYear
     *
     * @param date $startDateOfYear
     * @param date $endDateOfYear
     * @return object
     */
    public static function getYearlyStatsYear($startDateOfYear, $endDateOfYear)
    {
        return (new self)->model->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereBetween('created_at', [$startDateOfYear, $endDateOfYear])
            ->groupBy('month')
            ->get();
    }

    /**
     * getAllCommentStatic
     *
     * @return array
     */
    public static function getAllCommentStatic()
    {
        return (new self)->model->all();
    }

    /**
     * getMonthlyStats
     *
     * @param date $startDateOfMonth
     * @param date $endDateOfMonth
     * @return object
     */
    public static function getMonthlyStats($startDateOfMonth, $endDateOfMonth)
    {
        return (new self)->model->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as count'))
            ->whereBetween('created_at', [$startDateOfMonth, $endDateOfMonth])
            ->groupBy('day')
            ->get();
    }

    /**
     * getWeeklyStats
     *
     * @param date $startDateOfWeek
     * @param date $endDateOfWeek
     * @return object
     */
    public static function getWeeklyStats($startDateOfWeek, $endDateOfWeek)
    {
        return (new self)->model->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as count'))
            ->whereBetween('created_at', [$startDateOfWeek, $endDateOfWeek])
            ->groupBy('day')
            ->get();
    }
}
