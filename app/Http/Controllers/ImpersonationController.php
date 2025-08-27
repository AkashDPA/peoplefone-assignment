<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    public function start(Request $request, User $user)
    {
        $admin = $request->user();

        // already impersonating?
        if (session()->has('impersonator_id')) {
            return back()->with('status', 'Already impersonating. Stop first.');
        }

        //don’t allow impersonating as admins
        if ($user->role === 'admin') {
            abort(403, 'Cannot impersonate an admin.');
        }

        // store who started it
        session(['impersonator_id' => $admin->id]);

        // regenerate session (security) then log in as target
        $request->session()->migrate(true);
        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'Now impersonating '.$user->email);
    }

    public function stop(Request $request)
    {
        $impersonatorId = session('impersonator_id');
        if (!$impersonatorId) {
            return back()->with('status', 'Not impersonating.');
        }

        // clear the flag and switch back
        session()->forget('impersonator_id');
        $request->session()->migrate(true);
        Auth::loginUsingId($impersonatorId);

        return redirect()->route('users.index')->with('status', 'Stopped impersonation');
    }
}
