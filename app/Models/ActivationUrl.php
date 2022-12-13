<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivationUrl extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_page_id',
        'user_id',
        'url',
        'status',
    ];

    public function registrationPage()
    {
        return $this->belongsTo(RegistrationPage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function tickets()
    {
        return $this->belongsToMany(Ticket::class, 'activation_url_ticket');
    }
}
