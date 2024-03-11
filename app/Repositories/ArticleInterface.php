<?php

namespace App\Repositories;

/**
 * Interface ExampleRepository.
 */
interface ArticleInterface extends RepositoryInterface
{
    public function getListArticle();

    public function getArticleDetail($id);

    public function getMyArticle($id);

    public function addArticle($input);

    public function updateArticle($input);

    public function ajaxSearch($searchText);

    public function ajaxSearchMy($searchText, $idUser);

    public static function getAllArticleMain();

    public static function getArticle($id);

    public static function searchArticle($searchText, $n);

    public static function personalPage($idUser);

    public static function articleDetails($idArticle);

    public static function getYearlyStatsYear($startDateOfYear, $endDateOfYear);

    public static function getAllArticleStatic();

    public static function getMonthlyStats($startDateOfMonth, $endDateOfMonth);

    public static function getWeeklyStats($startDateOfWeek, $endDateOfWeek);
}
