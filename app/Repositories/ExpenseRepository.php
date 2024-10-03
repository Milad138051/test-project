<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Expense;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class ExpenseRepository.
 */
class ExpenseRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Expense::class;
    }

}
