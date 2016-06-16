<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'google_id', 'facebook_id', 'twitter_id', 'linkedin_id', 'github_id', 'bitbucket_id', 'avatar'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_users')->withTimestamps();
    }

    public function activation()
    {
        return $this->hasMany('App\Activation');
    }
}
