<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $created_at = date('Y-m-d H:i:s');
        $category_array = [
            'Sports',
            'Science & Tech',
            'Pop Culture'
        ];
        $category_insert_array = [];

        if (isset($category_array) && is_array($category_array) && count($category_array) > 0) {
            foreach ($category_array as $key => $value) {
                $category_insert_array[] = [
                    'name' => $value,
                    'created_at' => $created_at
                ];
            }
            Category::insert($category_insert_array);
        }
    }
}
