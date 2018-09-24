<?php

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
       $titles = [ 'روايات', 'كتب علمية', 'كتب دينية', 'كتب ثقافية', 'كتب تاريخية', 'سيرة ذاتية' ];
       foreach($titles as $title){
           // Make sure that slug is unique
           $count = \App\Category::where('slug', 'like', '%' . str_slug($title) . '%')->count();
           if($count > 0){
             $slug = str_slug($title) . '-' . $count;
           }else{
             $slug = str_slug($title);
           }
           $category = new \App\Category;
           $category->title = $title;
           $category->slug = $slug;
           $category->save();
       }
    }
}
