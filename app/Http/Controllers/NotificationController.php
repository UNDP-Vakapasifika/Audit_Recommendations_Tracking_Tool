<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        return view('notifications.index', [
            'notifications' => auth()->user()->notifications,
        ]);
    }

    public function show(string $type, int $resouceId, string $notificationId)
    {
        auth()->user()->notifications->find($notificationId)->markAsRead();

        switch ($type) {
            case 'caution':
                return redirect()->route('report.details.view', $resouceId);
            case 'supervised':
                return redirect()->route('action-plan.details', $resouceId);
            case 'notes':
                return redirect()->route('notes.recom.details', $resouceId);
            case 'due-30days':
                return redirect()->route('tracking_page', $resouceId);
            default:
                return redirect()->route('dashboard');
        }
    }

    public function markAsRead($id)
    {
        auth()->user()->notifications->find($id)->markAsRead();

        return redirect()->back()->with('success', 'Notification marked as read');
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'All notifications marked as read');
    }

    public function delete($id)
    {
        auth()->user()->notifications->find($id)->delete();

        return redirect()->back()->with('success', 'Notification deleted');
    }

    public function deleteAll()
    {
        auth()->user()->notifications()->delete();

        return redirect()->back()->with('success', 'All notifications deleted');
    }


    public function getModel()
    {
        return new FinalReport();
    }

}
