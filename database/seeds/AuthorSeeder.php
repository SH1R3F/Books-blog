<?php

use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'عباس محمود العقاد',
            'سيد قطب',
            'ستيفين كوفي',
            'محمد الغزالي',
            'محمد متولي الشعراوي',
            'مصطفي محمود',
            'احمد خالد توفيق',
            'ابراهيم الفقي'
        ];
        foreach($names as $name){
            $author = new \App\Author;
            $author->author_name = $name;
            $author->slug = str_slug($name);
            $author->save();
        }
    }
}
