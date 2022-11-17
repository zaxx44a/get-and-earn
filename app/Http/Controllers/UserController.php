<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display the user's Main Page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('user.index', ['userByDays' => $this->mapDataOfChart()]);
    }

    /**
     * Display the user Referral's Users List .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function users(Request $request)
    {
        $user = User::find($request->user_id) ?? auth()->user();
        abort_if(!$this->isAuthorized($user), 403, 'Not Authorized');

        return view('user.clients', [ 'user' => $user ]);
    }

    /**
     * Get Mapped Data to Paint The Chart .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    protected function mapDataOfChart()
    {
        $usersByDays = $days = [];

        $referralUsers = auth()->user()->flatChilds(auth()->user());
        foreach ($referralUsers as $user) {
            if ($user->created_at->between(now()->subDays(14), now())) {
                $usersByDays[$user->created_at->diffInDays(now())][] = $user;
            }
        }
        for ($i = 0; $i < 15; $i++) {
            $days[now()->subDays($i)->format('Y-m-d')] = isset($usersByDays[$i]) ? count($usersByDays[$i]) : 0;
        }
        return $days;
    }

    /**
     * check if user Authed to enter thier child's User List.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    protected function isAuthorized($user)
    {
        $isChild = $user->flatChilds($user->parent)->contains(function ($value, $key) {
            return $value->id == request()->user_id;
        });

        return $isChild || !isset(request()->user_id) || request()->user_id == auth()->id();
    }
}
