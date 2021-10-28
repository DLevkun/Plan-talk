<?php

namespace App\Repositories;

interface Repository
{
    public function getOneById($id);
    public function getAllByUser($user);
    public function getAll();
}
