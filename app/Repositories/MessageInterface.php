<?php

namespace App\Repositories;

/**
 * Interface ExampleRepository.
 */
interface MessageInterface extends RepositoryInterface
{
    public static function getAllMessageStatic();

    public function getListMessages($user, $id_to);

    public function getListUsers($id);

    public function getMessageViewChat($user, $_user);

    public function findMessageById($id);

    public function createMessage($input);
}
