<?php

namespace App\Repositories;

use App\Models\Article;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class ExampleRepository.
 */
class ArticleRepository extends BaseRepository implements ArticleInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function getModel()
    {
        return Article::class;
    }

    /**
     * allArticle
     *
     * @return object
     */
    public function getListArticle()
    {
        return $this->model->join('users', 'articles.id_user', '=', 'users.id')
            ->select('articles.*', 'users.name')
            ->orderBy('articles.id', 'desc');
    }

    /**
     * getArticleDetail
     *
     * @param int $id
     * @return object
     */
    public function getArticleDetail($id)
    {
        return $this->model
            ->when($id, fn ($q) => $q->where('id', '=', $id))
            ->first();
    }

    /**
     * getMyArticle
     *
     * @param int $id
     * @return object
     */
    public function getMyArticle($id)
    {
        return $this->model
            ->when($id, fn ($q) => $q->where('id_user', '=', $id))
            ->orderBy('id', 'desc');
    }

    /**
     * addArticle
     *
     * @param object $input
     * @return object
     */
    public function addArticle($input)
    {
        DB::beginTransaction();
        try {
            $newArticle = $this->model->create([
                'id_user' => $input->id_user,
                'title' => $input->title,
                'content' => $input->content,
            ]);
            DB::commit();

            return $newArticle;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * updateArticle
     *
     * @param object $input
     */
    public function updateArticle($input)
    {
        DB::beginTransaction();
        try {
            $user = $this->model->find($input->id_article);
            $updateData = [
                'title' => $input->title,
                'content' => $input->content,
            ];
            $user->update($updateData);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * ajaxSearch
     *
     * @param string $search_text
     * @return object
     */
    public function ajaxSearch($search_text)
    {
        return $this->model->join('users', 'articles.id_user', '=', 'users.id')
            ->select('articles.*', 'users.name')
            ->where('articles.title', 'like', '%' . $search_text . '%')
            ->orWhere('articles.content', 'like', '%' . $search_text . '%')
            ->orWhere('users.name', 'like', '%' . $search_text . '%')
            ->orderBy('articles.id', 'desc');
    }

    /**
     * ajaxSearch
     *
     * @param string $search_text
     * @param int $id_user
     * @return object
     */
    public function ajaxSearchMy($search_text, $id_user)
    {
        return $this->model->where('id_user', $id_user)
            ->where(function ($query) use ($search_text) {
                $query->where('title', 'like', '%' . $search_text . '%')
                    ->orWhere('content', 'like', '%' . $search_text . '%');
            })
            ->orderBy('id', 'desc');
    }

    /**
     * getAllArticleMain
     *
     * @return object
     */
    public static function getAllArticleMain()
    {
        return (new self)->model->join('users', 'users.id', '=', 'articles.id_user')
            ->leftjoin('likeds', 'likeds.id_article', '=', 'articles.id')
            ->select('articles.*', 'users.*', 'articles.id as id_article', 'users.id as id_user', 'likeds.id_users as user_likes')
            ->withCount('commentsCount')
            ->where('users.status', '!=', 0)
            ->orderBy('articles.id', 'DESC');
    }

    /**
     * getArticle
     *
     * @param $id
     * @return object
     */
    public static function getArticle($id)
    {
        return (new self)->model
            ->when($id, fn ($q) => $q->where('id', '=', $id))
            ->first();
    }

    /**
     * searchArticle
     *
     * @param string $search_text
     * @param int $n
     * @return object
     */
    public static function searchArticle($search_text, $n)
    {
        return (new self)->model->where('title', 'like', '%' . $search_text . '%')->take(10 - $n)->get();
    }

    /**
     * personalPage
     *
     * @param int $id_user
     * @return object
     */
    public static function personalPage($id_user)
    {
        return (new self)->model->where('id_user', $id_user)
            ->join('users', 'users.id', '=', 'articles.id_user')
            ->leftjoin('likeds', 'likeds.id_article', '=', 'articles.id')
            ->select('articles.*', 'users.*', 'articles.id as id_article', 'users.id as id_user', 'likeds.id_users as user_likes')
            ->withCount('commentsCount')
            ->orderBy('articles.id', 'DESC');
    }

    /**
     * personalPage
     *
     * @param int $id_article
     * @return object
     */
    public static function articleDetails($id_article)
    {
        return (new self)->model->where('articles.id', $id_article)
            ->join('users', 'users.id', '=', 'articles.id_user')
            ->leftjoin('likeds', 'likeds.id_article', '=', 'articles.id')
            ->select('articles.*', 'users.*', 'articles.id as id_article', 'users.id as id_user', 'likeds.id_users as user_likes')
            ->withCount('commentsCount')
            ->orderBy('articles.id', 'DESC')
            ->get();
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
     * getAllArticleStatic
     *
     * @return array
     */
    public static function getAllArticleStatic()
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
