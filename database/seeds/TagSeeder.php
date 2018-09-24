<?php

use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = [ 'تشويق', 'رعب', 'ثقافة', 'دين', 'اصول الفقه', 'مباحث', 'العقيدة', 'الفرق', 'النحو', 'اللغة' ];
        foreach($titles as $title){
            // Make sure that slug is unique
            $count = \App\Tag::where('slug', 'like', '%' . str_slug($title) . '%')->count();
            if($count > 0){
              $slug = str_slug($title) . '-' . $count;
            }else{
              $slug = str_slug($title);
            }
            $tag = new \App\Tag;
            $tag->title = $title;
            $tag->slug  = $slug;
            $tag->save();
        }
    }
}
