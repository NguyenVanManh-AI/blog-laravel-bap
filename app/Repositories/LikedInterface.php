<?php

namespace App\Repositories;

/**
 * Interface ExampleRepository.
 */
interface LikedInterface extends RepositoryInterface
{
    public function getLiked($idArticle);

    public function creatLiked($newLiked);

    public static function deleteLiked($idArticle);
}
