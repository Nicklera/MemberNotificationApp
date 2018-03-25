<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            'user_id' => 1,
            'parent_id' => 0,
            'name' => 'All Tags',
            'notes' => ''
        ]);      
    }  
}
