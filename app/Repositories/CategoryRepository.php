<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryRepository implements Repository
{
    /**
     * Get all categories
     * @return Category[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(){
        $categories = Category::all();
        return $categories;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getOneById($id)
    {

    }

    /**
     * @codeCoverageIgnore
     */
    public function getAllByUser($user)
    {

    }
}
