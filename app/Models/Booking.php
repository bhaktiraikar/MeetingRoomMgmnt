<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'meeting_room_id', 'meeting_name', 'start_time', 'duration', 'members', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function meetingRoom()
    {
        return $this->belongsTo(MeetingRoom::class);
    }
}
