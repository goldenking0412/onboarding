<?php

namespace App;

use App\Models\Answer;
use App\Models\Ticket;
use App\Models\Comment;
use Laravel\Spark\User as SparkUser;

/**
 * Class User
 * @package App
 *
 * @property string type
 */
class User extends SparkUser
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'slug',
        'type',
        'password',
        'message',
        'project_name',
        'asset_url',
        'project_name',
        'last_login_at',
        'is_archived',
        'archived_at',
        'assettype',
        'prototypetype',
        'admin_notes'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'authy_id',
        'country_code',
        'phone',
        'two_factor_reset_code',
        'card_brand',
        'card_last_four',
        'card_country',
        'billing_address',
        'billing_address_line_2',
        'billing_city',
        'billing_zip',
        'billing_country',
        'extra_billing_information',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'trial_ends_at' => 'datetime',
        'uses_two_factor_auth' => 'boolean',
        'last_login_at' => 'datetime',
        'is_archived' => 'boolean',
        'archived_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->type == 'admin';
    }

    public function assets()
    {
        return $this->hasOne(Answer::class)->where('type', 'assets');
    }

    public function prototype()
    {
        return $this->hasOne(Answer::class)->where('type', 'prototype');
    }

    public function questionAnswers()
    {
        return $this->hasMany(Answer::class)->whereNotNull('question_id')->with(['question' => function ($q){
            $q;
        }]);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * A user can have many comments
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the user that created ticket
     * @param  User  $user_id
     */
    public static function getTicketOwner($user_id)
    {
        return static::where('id', $user_id)->firstOrFail();
    }
}
