<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        return inertia(
            'Notification/Index',
            [
                'notifications' => $request->user()
                    ->unreadNotifications()->paginate(10)
            ]
        );
    }

    public function update(DatabaseNotification $notification)
    {
        $this->authorize('update', $notification);

        $notification->markAsRead();

        return redirect()->back()
            ->with('success', 'Powiadomienie oznaczone jako przeczytane');
    }
}
