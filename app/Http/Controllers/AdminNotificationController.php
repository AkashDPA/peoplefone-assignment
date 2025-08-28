<?php

namespace App\Http\Controllers;

use App\DataTables\AdminNotificationsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNotificationRequest;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AdminNotificationsDataTable $dataTable)
    {
        return $dataTable->render('admin.notifications.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // for the select—keep light, email is enough
        $users = User::orderBy('name')->where('role', 'user')->get(['id', 'email', 'name']);
        $types = config('notifications.type');
        return view('admin.notifications.create', compact('users', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreNotificationRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;

        DB::transaction(function () use ($data) {
            $n = Notification::create($data);

            if ($n->destination == 'all') {
                //select in chunk
                //dont use model to keep low footprint
                DB::table('users')->where('role', 'user')->select('id')
                    ->chunkById(1000, function ($chunk) use ($n) {
                        $rows = $chunk->map(function($u) use ($n) {
                            return [
                                'user_id' => $u->id,
                                'notification_id' => $n->id,
                            ];
                        })
                    ->all();
                
                    if (!empty($rows)) {
                        UserNotification::insert($rows);
                    }
                });
                
            } else {
                // destination=user
                UserNotification::create([
                    'user_id' => (int) $data['user_id'],
                    'notification_id' => $n->id,
                ]);
            }
        });

        return redirect()
            ->route('admin.notifications.index')
            ->with('status', 'Notification posted.');
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
}
