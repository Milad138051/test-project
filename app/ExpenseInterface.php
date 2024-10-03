<?php

namespace App;

use App\Models\Expense;
use http\Env\Request;

interface ExpenseInterface
{
    public function all(): Collection;
    public function find(Expense $expense): ?Expense;
    public function create(): Expense;
    public function update(Expense $expense, array $data);
    public function delete(int $id): bool;
}
