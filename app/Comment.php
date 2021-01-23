<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  //comments table in database
  protected $guarded = [];
  // user who has commented

  public function author()
  {
    return $this->belongsTo('App\User', 'from_user');
  }
  
  // returns post of any comment
  public function posts()
  {
    return $this->belongsTo('App\Post', 'on_post');
  }
}
