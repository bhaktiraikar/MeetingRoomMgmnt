<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'plan', 'max_bookings', 'subscribed_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
