<?php

namespace App\Repositories;

/**
 * Interface ExampleRepository.
 */
interface NotifyInterface extends RepositoryInterface
{
    public static function addNotify($input);

    public static function findNotify($input);

    public static function findNotifyById($id);

    public static function getAllNotify($id);

    public static function getAllNotifyStatic();

    public static function deleteNotify($idArticle);
}
