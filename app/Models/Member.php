<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Member extends Model
{
    protected $table = "members";

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function tags()
    {
        return $this->hasMany(MemberTag::class, 'member_id', 'id');
    }

    public function families()
    {
        return $this->hasMany(FamilyMember::class, 'member_id', 'id');
    }
    public function family()
    {
        return $this->hasOne(Family::class, 'member_id', 'id');
    }

    public function scopeBetween($query, Carbon $from, Carbon $to)
    {
        $query->whereBetween('dob', [$from, $to]);
    }
    
    public function getFullNameAttribute()
    {
        return $this->first_name. ' ' . $this->last_name;
    }

    /**
    * Accessor for Age.
    */
    public function getAgeAttribute()
    {
        return Carbon::parse($this->dob)->age;
    }
}
