<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionSection extends Model
{
  protected $fillable = [
    'question_order', 
    'name'
  ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
