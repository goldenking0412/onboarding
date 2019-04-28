<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 */
class Survey extends Model
{

    public function sections()
    {
        return $this->hasMany(QuestionSection::class);
    }
}
