<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function create()
    {
        $clients = \App\Models\User::where('role', 'client')->get();
        $colis = \App\Models\Colis::all();
        return view('notifications.create', compact('clients', 'colis'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'receiver_id' => 'required|exists:users,id',
        'colis_id' => 'required|exists:colis,id',
        'title' => 'required|string|max:255',
        'message' => 'required|string',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
    ]);

    Notification::create([
        'sender_id' => Auth::id(),
        'receiver_id' => $request->receiver_id,
        'colis_id' => $request->colis_id,
        'title' => $request->title,
        'message' => $request->message,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
    ]);

    return response()->json(['success' => true]);
    }


    public function index()
    {
        $notifications = Notification::where('receiver_id', Auth::id())
            ->latest()->get();
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('receiver_id', Auth::id())
            ->firstOrFail();

        $notification->update(['is_read' => true]);

        return redirect()->back();
    }

    public function showMap($id)
    {
    $notification = Notification::where('id', $id)
        ->where('receiver_id', Auth::id())
        ->firstOrFail();

    return view('notifications.map', compact('notification'));
    }
}