<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class MeetingRoom extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'capacity'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
