<?php
/**
 * Created by PhpStorm.
 * User: fan
 * Date: 21/08/2017
 * Time: 15:42
 */
use App\Model\Page;

class PageTableSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        // TODO: Implement run() method.
        DB::table('pages')->delete();

        for ($i = 0; $i < 10; $i ++) {
            Page::create([
                'title' => 'Title ' . $i,
                'slug' => 'first-page',
                'body' => 'Body '.$i,
                'user_id' => 1,
            ]);
        }
    }
}