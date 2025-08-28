<?php

namespace App\Http\Controllers;

use App\DataTables\UserNotificationsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNotificationRequest;
use App\Models\Notification;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class UserNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserNotificationsDataTable $dataTable)
    {
        return $dataTable->render('users.notifications.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreNotificationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        //
    }

    public function markRead(Request $request)
    {
        UserNotification::where('id', $request->post('id'))
            ->where('user_id', auth()->id())
            ->update(['read_at' => now()]);
    
        return response()->json(['status' => 'ok']);
    }
}
