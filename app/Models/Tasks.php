<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $table = 'task_table';
    protected $fillable = ['task_name', 'description', 'deadline', 'status', 'admin_id','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

   
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    
    use HasFactory;

}
