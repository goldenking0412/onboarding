<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $fillable = ['name', 'user_id'];

  public function user() {
    return $this->belongsTo(User::class);
  }
  public function articles()
  {
    return $this->belongsToMany(Article::class);
  }
}
