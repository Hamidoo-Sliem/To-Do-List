<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table='categories';     
	protected $primaryKey ='id';
	protected $guarded = [];  
	
	protected $hidden = []; 
 
     public $timestamps = false;

     public function _task() {
        return $this->hasMany(Task::class,'category_id');
    }
     
}
