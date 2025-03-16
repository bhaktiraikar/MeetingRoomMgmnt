<?php

namespace App\Http\Controllers;

use App\Models\MeetingRoom;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Requests\BookMeetingRequest;
use Carbon\Carbon;

class MeetingRoomController extends Controller
{
    // Fetch all meeting rooms
    public function index()
    {
        return MeetingRoom::all();
    }

    // Store new meeting room
    public function store(BookMeetingRequest $request)
    {
        // try {
        //     //code...
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
        $data = $request->validated();
        return Booking::create($data);
    }

    // Show single meeting room details
    public function show(MeetingRoom $meetingRoom)
    {
        return $meetingRoom;
    }

    // Update meeting room
    public function update(MeetingRoomRequest $request, MeetingRoom $meetingRoom)
    {
        $meetingRoom->update($request->validated());
        return $meetingRoom;
    }

    // Soft delete meeting room
    public function destroy(MeetingRoom $meetingRoom)
    {
        $meetingRoom->delete();
        return response()->json(['message' => 'Meeting Room deleted successfully']);
    }

    // Book a meeting room
    public function book(Request $request)
    {
        $request->validate([
            'meeting_name' => 'required|string',
            'start_time' => 'required|date|after:now',
            'duration' => 'required|in:30,60,90',
            'members' => 'required|integer|min:1',
            'meeting_room_id' => 'required|exists:meeting_rooms,id',
        ]);

        $user = auth()->user();

        // Check user booking limit based on subscription plan
        $todayBookings = Booking::where('user_id', $user->id)
            ->whereDate('start_time', Carbon::today())
            ->count();

        $maxBookings = match($user->plan) {
            'free' => 3,
            'basic' => 5,
            'advance' => 7,
            'premium' => 10,
        };

        if ($todayBookings >= $maxBookings) {
            return response()->json(['error' => 'Booking limit reached'], 403);
        }

        $booking = Booking::create([
            'user_id' => $user->id,
            'meeting_room_id' => $request->meeting_room_id,
            'meeting_name' => $request->meeting_name,
            'start_time' => $request->start_time,
            'duration' => $request->duration,
            'members' => $request->members,
            'status' => 'booked',
        ]);

        return $booking;
    }

    // Get user's bookings
    public function myBookings(Request $request)
    {
        $user = auth()->user();

        $bookings = Booking::where('user_id', $user->id)
            ->when($request->filter === 'past', fn($q) => $q->where('start_time', '<', now()))
            ->when($request->filter === 'upcoming', fn($q) => $q->where('start_time', '>=', now()))
            ->paginate(10);

        return $bookings;
    }
}
