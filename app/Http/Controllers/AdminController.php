<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    
    /**
     * Display the user's list for admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('admin.index', [ 'children' => User::all() ]);
    }

    /**
     * Display the user's profile form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function adminUser(Request $request)
    {
        if (is_null($request->user_id)) {return redirect()->route('admin.index');}

        $user = User::find($request->user_id);
        
        return view('admin.index', [ 'children' =>  $user->childs, 'user' => $user ]);

    }

    /**
     * Display the user's profile form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, User $administration)
    {
        return view('admin.edit', [ 'user' => $administration]);
    }

    /**
     * Update the user's profile information.
     *
     * @param  \App\Http\Requests\AdminUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AdminUpdateRequest $request, User $administration)
    {
        $administration->fill($request->validated());

        if ($administration->isDirty('email')) {
            $administration->email_verified_at = null;
        }

        $administration->save();
        User::flushQueryCache();

        return Redirect::route('administration.edit', ['administration' => $administration->id])->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, User $administration)
    {
        $request->validateWithBag('userDeletion', [
            'email' => [
                'required', 
                function ($attribute, $value, $fail) use ($administration)  {
                    if ($value !== $administration->email) {
                        $fail('The '.$attribute.' is invalid.');
                    }
                }
            ],
        ]);
        $administration->delete();
        User::flushQueryCache();

        return Redirect::to( route('admin.index') );
    }
}
