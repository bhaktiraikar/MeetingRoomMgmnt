<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MeetingRoom;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Booking;
use Illuminate\Support\Facades\Hash;

class MeetingRoomSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Meeting Rooms
        $rooms = [
            ['name' => 'Meeting Room 1', 'capacity' => 3],
            ['name' => 'Meeting Room 2', 'capacity' => 10],
            ['name' => 'Meeting Room 3', 'capacity' => 15],
            ['name' => 'Meeting Room 4', 'capacity' => 2],
            ['name' => 'Meeting Room 5', 'capacity' => 1],
        ];

        foreach ($rooms as $room) {
            MeetingRoom::create($room);
        }

        // Seed Users
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'plan' => 'free'
        ]);

        // Seed Subscriptions
        $subscriptions = [
            ['user_id' => 1, 'plan' => 'basic', 'max_bookings' => 5, 'subscribed_at' => now()],
            ['user_id' => 1, 'plan' => 'advance', 'max_bookings' => 7, 'subscribed_at' => now()],
            ['user_id' => 1, 'plan' => 'premium', 'max_bookings' => 10, 'subscribed_at' => now()],
        ];

        foreach ($subscriptions as $subscription) {
            Subscription::create($subscription);
        }

        // Seed Bookings
        Booking::create([
            'user_id' => 1,
            'meeting_room_id' => 1,
            'meeting_name' => 'Initial Meeting',
            'start_time' => now()->addHour(),
            'duration' => 60,
            'members' => 2,
            'status' => 'booked'
        ]);
    }
}
