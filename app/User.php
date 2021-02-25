<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\QueryException;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    public function competitions()
    {
        return $this->hasMany(Competition::class);
    }

    public function rules()
    {
        return $this->hasMany(Rule::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function matches()
    {
        return $this->hasMany(Match::class);
    }

    public function addCompetition($competition)
    {
        return $this->competitions()->create($competition);
    }

    public function addSeason($season)
    {
        return $this->seasons()->create($season);
    }

    public function addRule($rule)
    {
        return $this->rules()->create($rule);
    }

    public function addTeam($team)
    {
        $result = null;

        try {
            $result = $this->teams()->create($team);
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];

            if ($errorCode === 1062) {
                $result = false;
            }
        }

        return $result;
    }

    public function addMatch($match)
    {
        return $this->matches()->create($match);
    }

    public function addPlayer($player)
    {
        return $this->players()->create($player);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::whereName($role)->firstOrFail();
        }

        return $this->roles()->sync($role, false);
    }

    public function abilities()
    {
        return $this->roles->map->abilities->flatten()->pluck('name')->unique();
    }
}
