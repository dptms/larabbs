<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = app(\Faker\Generator::class);
        $user_ids = \App\Models\User::pluck('id')->toArray();
        $category_ids = \App\Models\Category::pluck('id')->toArray();
        $topics = factory(Topic::class)->times(100)->make()->each(function ($topic) use ($faker, $user_ids, $category_ids) {
            $topic->user_id = $faker->randomElement($user_ids);
            $topic->category_id = $faker->randomElement($category_ids);
        });

        Topic::insert($topics->toArray());
    }

}

