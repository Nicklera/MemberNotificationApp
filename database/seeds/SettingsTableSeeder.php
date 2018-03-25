<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('settings')->insert([
            [
                'setting_key' => 'company_name',
                'setting_value' => 'Slavic Christian Center',
            ],
            [
                'setting_key' => 'company_address',
                'setting_value' => 'Tacoma WA',
            ],
            [
                'setting_key' => 'company_currency',
                'setting_value' => 'USD',
            ],
            [
                'setting_key' => 'company_website',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'company_country',
                'setting_value' => 'USA',
            ],
            [
                'setting_key' => 'system_version',
                'setting_value' => '1.0',
            ],
            [
                'setting_key' => 'sms_enabled',
                'setting_value' => '1',
            ],
            [
                'setting_key' => 'active_sms',
                'setting_value' => 'clickatell',
            ],
            [
                'setting_key' => 'portal_address',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'company_email',
                'setting_value' => 'admin@scc.org',
            ],
            [
                'setting_key' => 'currency_symbol',
                'setting_value' => '$',
            ],
            [
                'setting_key' => 'currency_position',
                'setting_value' => 'left',
            ],
            [
                'setting_key' => 'company_logo',
                'setting_value' => 'log.png',
            ],
            [
                'setting_key' => 'twilio_sid',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'twilio_token',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'twilio_phone_number',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'routesms_host',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'routesms_username',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'routesms_password',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'routesms_port',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'sms_sender',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'clickatell_username',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'clickatell_password',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'clickatell_api_id',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'infobip_username',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'infobip_password',
                'setting_value' => '',
            ],

            [
                'setting_key' => 'password_reset_subject',
                'setting_value' => 'Password reset instructions',
            ],
            [
                'setting_key' => 'password_reset_template',
                'setting_value' => 'Password reset instructions',
            ],
            [
                'setting_key' => 'follow_up_sms_template',
                'setting_value' => 'Dear {firstName} {lastName}, a follow up has been assigned to you for {followUpName}:{followUpID}. Due date:{dueDate}',
            ],
            [
                'setting_key' => 'follow_up_email_template',
                'setting_value' => '<b>{followUpCategory}</b><br>Dear {firstName} {lastName}, You have been assigned to follow up on {followUpName}:{followUpID}.<br><b>Due Date</b>:{followUpDueDate}.<br>{followUpNotes} <a href="{followUpLink}">Click here</a> to view the follow up',
            ],
            [
                'setting_key' => 'follow_up_email_subject',
                'setting_value' => 'Follow up assigned for {followUpName}',
            ],
            [
                'setting_key' => 'enable_cron',
                'setting_value' => '0',
            ],
            [
                'setting_key' => 'cron_last_run',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'google_maps_key',
                'setting_value' => '',
            ]
            ,
            [
                'setting_key' => 'stripe_secret_key',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'stripe_publishable_key',
                'setting_value' => '',
            ]
            ,
            [
                'setting_key' => 'update_url',
                'setting_value' => '',
            ],
            [
                'setting_key' => 'allow_client_login',
                'setting_value' => '0',
            ],
            [
                'setting_key' => 'allow_self_registration',
                'setting_value' => '0',
            ],
            [
                'setting_key' => 'welcome_note',
                'setting_value' => 'Welcome!',
            ],
            [
                'setting_key' => 'volunteer_assignment_email_template',
                'setting_value' => 'Dear {memberName}, you have been assigned to volunteer at:{eventName}.<br><hr>Role:{roles}<br>Event Dates: {eventDates}<br>Event Details:{eventDescription}<br>Extra Notes: {notes}',
            ],
            [
                'setting_key' => 'email_volunteer_assignment',
                'setting_value' => '1',
            ],
            [
                'setting_key' => 'volunteer_assignment_email_subject',
                'setting_value' => 'Volunteer Assignment',
            ],

        ]);
    }
}
