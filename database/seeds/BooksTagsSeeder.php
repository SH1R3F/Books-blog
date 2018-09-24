<?php

use Illuminate\Database\Seeder;

class BooksTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(range(1, 10) as $i){
            DB::table('book_tag')->insert([
                'book_id' => rand(1, 10),
                'tag_id' => rand(1, 10)
            ]);
        }
    }
}
