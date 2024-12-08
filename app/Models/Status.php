<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $table='statuses';     
	protected $primaryKey ='id';
	protected $guarded = [];  
	
	protected $hidden = []; 
 
     public $timestamps = false;

     public function _task() {
        return $this->hasMany(Task::class,'status_id');
    }
}
