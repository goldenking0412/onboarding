<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property bool is_reviewed
 * @property bool is_complete
 */
class Answer extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_reviewed'   => 'boolean',
        'is_complete'   => 'boolean',
        'is_received'   => 'boolean',
    ];

    protected $appends = [
        'is_finished'
    ];

    /**
     * @return bool
     */
    public function getIsFinishedAttribute()
    {
        if(!$this->attributes['is_reviewed'] and !$this->attributes['is_complete']){
            return true;
        }

        return $this->attributes['is_reviewed'] and $this->attributes['is_complete'];
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function assetComplete()
    {
        if(!$this->is_reviewed){
            return true;
        }else{
            if($this->is_complete){
                return true;
            }else{
                return false;
            }
        }
    }
}
