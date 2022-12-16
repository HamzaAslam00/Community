<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'image',
    ];

    public function registrationPages()
    {
        return $this->belongsToMany(RegistrationPage::class, 'group_registration_page');
    }
}
