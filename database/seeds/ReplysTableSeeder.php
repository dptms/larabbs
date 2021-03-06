<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;

class ReplysTableSeeder extends Seeder
{
    public function run()
    {
        $user_ids = \App\Models\User::all()->pluck('id')->toArray();
        $topic_ids = \App\Models\Topic::all()->pluck('id')->toArray();
        $faker = app(Faker\Generator::class);
        $replys = factory(Reply::class)->times(1000)->make()->each(function ($reply) use ($user_ids, $topic_ids, $faker) {
            $reply->topic_id = $faker->randomElement($topic_ids);
            $reply->user_id = $faker->randomElement($user_ids);
        });

        Reply::insert($replys->toArray());
    }

}

