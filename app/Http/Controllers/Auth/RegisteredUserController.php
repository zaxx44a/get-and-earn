<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->countVisitor();
        return view('auth.register');
    }

    /**
     * Count Number of unique visitors Per Referral link.
     *
     * @return Void
     */
    protected function countVisitor()
    {
        $user = $this->isReferralLink();
        if ( !!$user && !request()->session()->get('visit_counted')) {
            $user->increment('registration_views');
            request()->session()->put('visit_counted', true);
        }
    }

    /**
     * check if it's Referral link and it's for Real User.
     *
     * @return \App\Models\User | Boolean
     */
    protected function isReferralLink()
    {
        $user = !is_null(request()->referral) ? User::find(request()->referral) : false;
        return !!$user ? $user : false;
    }
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $request->validate([
            'phone' => ['required', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'avatar' => ['required', 'image', 'max:5120', 'mimes:jpeg,png,jpg,gif,svg'],
        ]);

        $imageName = time() . '.' . $request->avatar->extension();
        $request->avatar->move(public_path('images'), $imageName);

        $user = User::create([
            'phone' => $request->phone,
            'email' => $request->email,
            'name' => $request->name,
            'avatar' => $imageName,
            'password' => Hash::make($request->password),
            'date_of_birth' => $request->birth ?? null,
            'referral_id' => $request->referral_id ?? null,
        ]);

        $user->assignRole('user');
        event(new Registered($user));
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
