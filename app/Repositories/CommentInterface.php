<?php

namespace App\Repositories;

/**
 * Interface ExampleRepository.
 */
interface CommentInterface extends RepositoryInterface
{
    public static function deleteCommentArticle($idArticle);

    public function getComment($idArticle);

    public function updateComment($newComment);

    public function deleteComment($idComment);

    public function addComment($newComment);

    public function personalPage($idArticle);

    public static function articleDetails($idArticle);

    public function getAllComment();

    public function ajaxSearch($searchText);

    public static function getYearlyStatsYear($startDateOfYear, $endDateOfYear);

    public static function getAllCommentStatic();

    public static function getMonthlyStats($startDateOfMonth, $endDateOfMonth);

    public static function getWeeklyStats($startDateOfWeek, $endDateOfWeek);
}
