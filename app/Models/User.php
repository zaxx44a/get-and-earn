<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Rennokki\QueryCache\Traits\QueryCacheable;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles, HasFactory, Notifiable, QueryCacheable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'referral_id',
        'date_of_birth'
    ];
    public $flat = [];
    public $cacheFor = 30; // cache time, in seconds
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'datetime',
    ];

    /**
     * Get the child user who register via user referral link.
     */
    public function childs()
    {
        return $this->hasMany(User::class, 'referral_id')->with('childs');
    }

    /**
     * Get flat set of all children.
    */
    public function flatChilds($user, $level = 1)
    {
            foreach (($user->childs ?? []) as $child) {
                if(isset($child->childs) && !!$child->childs->count()){
                    $this->flatChilds($child, $level + 1);
                    $this->flat = array_merge($child->flat, $this->flat);
                }
                $child['level'] = $level;
                $this->flat[] = $child;
            }
        return collect($this->flat)->unique('id');
    }

    /**
     * recursive calling function to calculate points for all user's parents' .
     */
    public function incrementCredit()
    {
        $referralUser = $this->flatChilds($this);
        if($referralUser->count() < 6) {
            $this->increment('credit', 5);
        } elseif($referralUser->count() <= 11) {
            $this->increment('credit', 7);
        } elseif($referralUser->count() > 11) {
            $this->increment('credit', 10);
        }
        return isset($this->parent) && !!$this->parent ? $this->parent->incrementCredit() : null;

    }

    /**
     * Get the parent user who is user registerd via his link.
     */
    public function parent()
    {
        return $this->hasOne(User::class, 'id', 'referral_id');
    }



}
