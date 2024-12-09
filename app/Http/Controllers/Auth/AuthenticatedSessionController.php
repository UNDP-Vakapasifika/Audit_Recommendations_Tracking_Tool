<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Stakeholder;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View|RedirectResponse
    {
        // Check if both tables are empty
        if (User::count() === 0 || Stakeholder::count() === 0) {
            return redirect()->route('setup.index');
        }

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function getModel()
    {
        return new AuthenticatedSessionController();
    }

    public function getAttributes(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return [
                'message' => 'No user is logged in',
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
            ];
        }

        // You can choose which attributes to log; here's an example
        return [
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'ip_address' => $request->ip(), // Log IP address of the user
            'user_agent' => $request->header('User-Agent'), // Log user agent
        ];
    }
}

