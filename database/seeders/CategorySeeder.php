<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Cost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $titles=['حمل و نقل','ایاب ذهاب','خرید تجهیزات'];
        DB::statement('truncate categories');
        foreach($titles as $title)
        {
            Category::factory()->create(['title'=>$title]);
        }
    }
}
