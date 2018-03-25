<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('roles')->insert([
            [
                'slug' => 'admin',
                'name' => 'Admin',
                'permissions' => '{
                    "members":true,
                    "members.view":true,
                    "members.update":true,
                    "members.delete":true,
                    "members.create":true,
                    "events":true,
                    "events.create":true,
                    "events.update":true,
                    "events.delete":true,
                    "events.view":true,
                    "communication":true,
                    "communication.create":true,
                    "communication.delete":true,
                    "users":true,
                    "users.view":true,
                    "users.create":true,
                    "users.update":true,
                    "users.delete":true,
                    "users.roles":true,
                    "settings":true,
                    "audit_trail":true,
                    "dashboard":true,
                    "dashboard.members_statistics":true,
                    "dashboard.calendar":true,
                    "dashboard.contributions_statistics":true,
                    "dashboard.finance_graph":true,
                    "dashboard.tags_statistics":true,
                    "tags":true,
                    "tags.view":true,
                    "tags.create":true,
                    "tags.update":true,
                    "tags.delete":true,
                    "follow_ups":true,
                    "follow_ups.view":true,
                    "follow_ups.create":true,
                    "follow_ups.update":true,
                    "follow_ups.delete":true
                }'
            ],
            [
                'slug' => 'editor',
                'name' => 'Editor',
                'permissions' => '{
                    "members":true,
                    "members.view":true,
                    "members.update":true,
                    "members.delete":true,
                    "members.create":true,
                    "events":true,
                    "events.create":true,
                    "events.update":true,
                    "events.delete":true,
                    "events.view":true,
                    "communication":true,
                    "communication.create":true,
                    "communication.delete":true,
                    "users":true,
                    "users.view":true,
                    "users.create":false,
                    "users.update":false,
                    "users.delete":false,
                    "users.roles":false,
                    "settings":false,
                    "audit_trail":false,
                    "dashboard":true,
                    "dashboard.members_statistics":true,
                    "dashboard.calendar":true,
                    "dashboard.tags_statistics":true,
                    "tags":true,
                    "tags.view":true,
                    "tags.create":false,
                    "tags.update":false,
                    "tags.delete":false,
                    "follow_ups":true,
                    "follow_ups.view":true,
                    "follow_ups.create":true,
                    "follow_ups.update":true,
                    "follow_ups.delete":true
                }'
            ]
        ]);
    }
}
