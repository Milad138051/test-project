<?php

namespace App;

use App\Models\Category;
use http\Env\Request;

interface CategoryInterface
{
    public function all(): Collection;
    public function find(Category $category): ?Category;
    public function create(): Category;
    public function update(Category $category, array $data);
    public function delete(int $id): bool;

}
