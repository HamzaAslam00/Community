<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'status',
    ];

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_registration_page');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
