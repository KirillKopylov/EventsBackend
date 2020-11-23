<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventUser;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

         Event::factory(100)->create()->each(function ($event) {
             $event->members()->saveMany(EventUser::factory(30)->make());
         });
    }
}
