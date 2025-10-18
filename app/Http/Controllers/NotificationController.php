<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use App\Services\Notifications\FireBase;

class NotificationController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $notifications = Notification::where('user_id', $userId)
            ->latest()
            ->take(10)
            ->get();

        $unreadCount = Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())->findOrFail($id);
        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject' => 'required|string',
            'message' => 'required|string',
            'module_id' => 'nullable|integer',
        ]);

        $notification = Notification::create([
            'user_id' => $validated['user_id'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'module_id' => $validated['module_id'] ?? null,
        ]);

        $user = User::find($validated['user_id']);

        if ($user && $user->fcm_token) {
            try {
                FireBase::send(
                    $validated['subject'],
                    $validated['message'],
                    [$user->fcm_token],
                    ['notification_id' => $notification->id]
                );
            } catch (\Exception $e) {
                \Log::error('FCM Error: ' . $e->getMessage());
            }
        }

        return response()->json(['success' => true, 'notification_id' => $notification->id]);
    }
}
