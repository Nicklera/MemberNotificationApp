<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use Faker\Generator as Faker;
use App\Models\Member;
use Carbon\Carbon;

$factory->define(Member::class, function (Faker $faker) {
    return [
        'first_name'        => $faker->firstName,
        'last_name'         => $faker->lastName,
        'email'             => $faker->email,
        'dob'               => Carbon::createFromFormat("Y-m-d", $faker->date(), 'America/Vancouver'),
        'gender'            => config('member.gender.options')[rand(0,2)],
        'trade'             => $faker->jobTitle,
        'marital_status'    => config('member.marital_status.options')[rand(0,4)],
        'mobile_phone'      => $faker->phoneNumber,
        'nationality'       => config('member.nationality.options')[rand(0,5)],
        'education'         => config('member.education.options')[rand(0,6)],
        'place_of_birth'    => $faker->city,
        'preferred_language'=> config('member.preferred_language.options')[rand(0,1)],
        'preferred_contact' => config('member.preferred_contact.options')[rand(0,1)]
    ];
});
