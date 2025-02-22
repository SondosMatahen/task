<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Comment;
use App\Post;

class User extends Authenticatable implements AuthenticatableContract, CanResetPasswordContract
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'users';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name', 'email', 'password'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = ['password', 'remember_token'];


  //Relation:: user has many posts
  public function posts()
  {
    return $this->hasMany('App\Post', 'author_id');
  }


  //Relation:: user has many comments
  public function comments()
  {
    return $this->hasMany('App\Comment', 'from_user');
  }

  public function can_post()
  {
    $role = $this->role;
    if ($role == 'author' || $role == 'admin') {
      return true;
    }
    return false;
  }

  public function is_admin()
  {
    $role = $this->role;
    if ($role == 'admin') {
      return true;
    }
    return false;
  }
}
