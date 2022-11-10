<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@szerveroldali.hu',
            'email_verified_at' => now(),
            'password' => bcrypt('adminpwd'),
            'remember_token' => Str::random(10),
          ]);

        $users = \App\Models\User::factory(10)->create();
        $items = \App\Models\Item::factory(10)->create();
        $comments = \App\Models\Comment::factory(10)->create();
        $labels = \App\Models\Label::factory(10)->create();

        foreach ($comments as $comment) {
                $comment->item()->associate($items->random())->save();
                $comment->user()->associate($users->random())->save();
        }
        foreach ($labels as $label) {
            $label->items()->sync(
                $items->random(3)
            );
        }
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
