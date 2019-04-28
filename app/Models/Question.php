<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 */
class Question extends Model
{


    /**
     * @param $query
     * @return mixed
     */
    public function scopeWithSection($query)
    {
        return $query->leftJoin(
            'question_sections',
            'questions.question_section_id',
            '=',
            'question_sections.id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user_answer()
    {
        return $this->hasOne(Answer::class, 'question_id', 'id');
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    /**
     * @return bool
     */
    public function isFinished()
    {
        if(!isset($this->user_answer) or empty($this->user_answer->value)){
            return false;
        }

        if(!$this->user_answer->is_finished){
            return false;
        }

        return true;
    }

    public function isReviewed()
    {
        if(!isset($this->user_answer) or empty($this->user_answer->value)){
            return false;
        }

        return $this->user_answer->is_reviewed;
    }
}
