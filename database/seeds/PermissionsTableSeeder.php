<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->truncate();
        $statement = "INSERT INTO `permissions` (`id`, `parent_id`, `name`, `slug`, `description`) VALUES
            (1, 0, 'Members', 'members', 'Access Members Module'),
            (2, 1, 'View members', 'members.view', 'View members'),
            (3, 1, 'Update members', 'members.update', 'Update members'),
            (4, 1, 'Delete members', 'members.delete', 'Delete members'),
            (5, 1, 'Create members', 'members.create', 'Add new members'),
            (6, 0, 'Events', 'events', 'Access events Module'),
            (7, 6, 'Create events', 'events.create', 'Create events'),
            (9, 6, 'Update events', 'events.update', 'Update events'),
            (10, 6, 'Delete events', 'events.delete', 'Delete events'),
            (11, 6, 'View events', 'events.view', 'View events'),
            (12, 0, 'Users', 'users', 'Access Users Module'),
            (13, 12, 'View Users', 'users.view', 'View Users '),
            (14, 12, 'Create Users', 'users.create', 'Create users'),
            (15, 12, 'Update Users', 'users.update', 'Update Users'),
            (16, 12, 'Delete Users', 'users.delete', 'Delete Users'),
            (17, 0, 'Manage Roles', 'users.roles', 'Manage user roles'),
            (18, 0, 'Settings', 'settings', 'Manage Settings'),
            (19, 0, 'Audit Trail', 'audit_trail', 'Access Audit Trail'),
            (20, 0, 'Dashboard', 'dashboard', 'Access Dashboard'),
            (21, 0, 'Follow Ups', 'follow_ups', 'Access Follow Ups'),
            (22, 21, 'View Follow Ups', 'follow_ups.view', ''),
            (23, 21, 'Create Follow Ups', 'follow_ups.create', ''),
            (24, 21, 'Update Follow Ups', 'follow_ups.update', ''),
            (25, 21, 'Delete Follow Ups', 'follow_ups.delete', ''),
            (26, 20, 'Member Statistics', 'dashboard.members_statistics', ''),
            (27, 20, 'Events Calendar', 'dashboard.calendar', ''),
            (28, 20, 'Tags Statistics', 'dashboard.tags_statistics', '');";
        DB::unprepared($statement);
    }
}
