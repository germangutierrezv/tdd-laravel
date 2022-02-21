<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
  use HasFactory;

  protected $guarded = [];

  public function tasks()
  {
    return $this->hasMany(Task::class)
      ->orderBy('order');
  }

  public function addTask($task)
  {
    // add user id if not present
    if (!in_array('user_id', $task) && auth()->check()) {
      $task['user_id'] = auth()->id();
    }

    return $this->tasks()->create($task);
  }
}
