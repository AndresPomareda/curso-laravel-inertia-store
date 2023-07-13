<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 700; $i++) {
            $title = Str::random(rand(2,50));
            Post::create(
                [
                    'title' => $title,
                    'slug' => str($title)->slug(),
                    'text' => Str::random(rand(5,500)),
                    'description' => Str::random(rand(2,150)),
                    'date' => Carbon::today()->subDays(rand(0,400)),
                    'posted' => ['yes', 'not'][rand(0,1)],
                    'type' => ['adverd','post','movie','course'][rand(0,3)],
                    'category_id' => Category::inRandomOrder()->first()->id,
                ]
            );
        }
    }
}
