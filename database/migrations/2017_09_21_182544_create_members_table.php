<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('branch_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->text('first_name')->nullable();
            $table->text('middle_name')->nullable();
            $table->text('last_name')->nullable();
            $table->enum('preferred_language', config('member.preferred_language.options'))->default(config('member.preferred_language.default'));
            $table->enum('preferred_contact', config('member.preferred_contact.options'))->default(config('member.preferred_contact.default'));
            $table->enum('nationality', config('member.nationality.options'))->default(config('member.nationality.default'));
            $table->text('place_of_birth')->nullable();
            $table->enum('education', config('member.education.options'))->default(config('member.education.default'));
            $table->text('trade')->nullable();
            $table->enum('gender', config('member.gender.options'))->default(config('member.gender.default'));
            $table->enum('department', config('member.department.options'))->default(config('member.department.default'));
            $table->enum('status', config('member.status.options'))->default(config('member.status.default'));
            $table->enum('marital_status', config('member.marital_status.options'))->default(config('member.marital_status.default'));
            $table->date('dob')->nullable();
            $table->date('deceased')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('work_phone')->nullable();
            $table->text('email')->nullable();
            $table->text('address')->nullable();
            $table->text('notes')->nullable();
            $table->text('photo')->nullable();
            $table->text('files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('members', function (Blueprint $table) {
            //
        });
    }
}
