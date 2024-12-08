<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table='tasks';     
	protected $primaryKey ='id';
	protected $guarded = [];  
	
	protected $hidden = []; 
    protected $dates = ['deleted_at'];
     public $timestamps = false;

     public function _user() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function _category() {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function _status() {
        return $this->belongsTo(Status::class,'status_id');
    }
}
