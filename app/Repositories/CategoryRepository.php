<?php
namespace App\Repositories;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Category;
class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface{
    public function __construct(Category $model)
    {
        parent::__construct($model);

    }

}
