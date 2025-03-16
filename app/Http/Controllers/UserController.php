<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\Booking;
use App\Http\Requests\BookMeetingRequest;

class UserController extends Controller
{
  public function login(Request $request)
  {
    $credentials = $request->only('email', 'password');
    $key = 'login_attempts_' . $request->ip();
    // dd($key);
    if (Cache::has($key) && Cache::get($key) >= 3) {
      return response()->json(['message' => 'Too many login attempts. Please try again after 24 hours.'], 429);
    }

    if (Auth::attempt($credentials)) {
      Cache::forget($key); // Reset attempts on successful login
      $user = Auth::user();
      $token = $user->createToken('MyApp')->plainTextToken;
      return response()->json(['token' => $token]);
    }

    Cache::increment($key);
    Cache::put($key, Cache::get($key), now()->addHours(24));

    return response()->json(['message' => 'Invalid credentials'], 401);
  }
  public function userProfile(Request $request)
    {
        return response()->json($request->user());
    }
    public function bookMeeting(BookMeetingRequest $request)
    {
        // try {
        //     //code...
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
        // $data = $request->validated();
        // return Booking::create($data);
        // if (!Gate::allows('book-meeting')) {
        //     abort(403, 'Unauthorized action.');
        // }
        // $this->authorize('bookMeeting', Booking::class);
        $validatedData = $request->validated();
    
        $meeting = Booking::create($validatedData);
    
        return response()->json(['message' => 'Meeting booked successfully!', 'data' => $meeting]);
    }
}

