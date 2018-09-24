<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = new Faker;
        $names = [
            'العادات السبع للناس الاكثر فعالية',
            'الرجال من المريخ والنساء من الزهرة',
            'رواية الاسود يليق بك',
            'رواية اديك في السقف تمحر اديك في الارض تفحر',
            'ادارة الوقت للكاتب ابراهيم الفقي',
            'في الحب والحياة',
            'سحر الكلمة',
            'حياة بلا توتر',
            'حول العالم في 200 يوم',
            'الطريق الي الامتياز او المقبول أيهما أقرب'
        ];
        foreach($names as $name){
            $book = new \App\Book;
            $book->book_name = $name;
            $book->thumbnail = 'thumbnails/' . $faker::create()->image(storage_path('app/public/thumbnails'), 200, 300, null, false);
            $book->slug = str_slug($name);
            $book->description = 'الديسكربشن ده للتجربة فقط لا غير. هنا يرقد الديسكربشن.';
            $book->book_file = 'books/elmo5-zakr-onsa.pdf';
            $book->category_id = rand(1, 6);
            $book->author_id = rand(1, 8);
            $book->user_id   = rand(1, 4);
            $book->save();
        }
    }
}
