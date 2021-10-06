<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryRepository
{
    public function getAllCategories(){
        $categories = Cache::store('redis')->rememberForever("all_categories", function(){
            return Category::all();
        });
        return $categories;
    }

}
