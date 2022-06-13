<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryRepository implements Repository
{
    public function getAll(){
        $categories = Category::all();
//        $categories = Cache::store('redis')->rememberForever("all_categories", function(){
//            return Category::all();
//        });
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
