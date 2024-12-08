<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\{Task,User,Category,Status};

class TaskController extends Controller
{
    public static $errors;

     public function __construct() {
        self::$errors = [];
        $this->middleware('guest:api');
     }


     public function _addNewTask(Request $req) {

        $v = \Illuminate\Support\Facades\Validator::make($req->all(), [
            'title' => ['required','unique:tasks'],
            'due_date' => ['required','date','after:yesterday'],
            'assign_to' => ['required','numeric','exists:users,id'],
            'category' => ['required','numeric','exists:categories,id'],
          ],[
            'title.required' => 'title:You must add a task title',
            'title.unique' => 'title:This title is already existed',
            'due_date.required' => 'due:You must add a due date',
            'due_date.date' => 'due:Duew date must be a date',
            'due_date.after' => 'due:Due date must be after yesterday',
            'assign_to.required' => 'assign:You must add user id',
            'assign_to.numeric' => 'assign:You must add a number',
            'assign_to.exists' => 'assign:the user id must be existed',
            'category.required' => 'category:You must add category id',
            'category.numeric' => 'category:You must add a number',
            'category.exists' => 'category:the category id must be existed'
          ]);

          if(count($v->errors()->all()) === 0) {
            
            $task = Task::insert([
                'title' => strip_tags(trim($req['title'])),
                'description' => strip_tags(trim($req['description'])) ?? null ,
                'user_id' => $req['assign_to'],
                'category_id' => $req['category'],
                'status_id' => 1,
                'due_date' => $req['due_date'],
                'created_at' => \DB::raw('NOW()')
            ]);
            Cache::flush();
            return response()->json([
                'status' => 'success',
                'message' => 'Task created Successfully',
            ]);

          }else {

            foreach($v->errors()->all() as $k=>$v) {
              if(str_contains($v,'title:')){
                self::$errors['title'] = str_ireplace('title:','',$v);
              }
              if(str_contains($v,'due:')){
                self::$errors['due_date'] = str_ireplace('due:','',$v);
              }
              if(str_contains($v,'category:')){
                self::$errors['category'] = str_ireplace('category:','',$v);
              }
              if(str_contains($v,'assign:')){
                self::$errors['assign_to'] = str_ireplace('assign:','',$v);
              }
            }
    
            return response()->json(["status" => "error","errors" => self::$errors]);
          }
     }


     public function _updateTask(Request $req,$id) {

        $v = \Illuminate\Support\Facades\Validator::make($req->all(), [
          'title' => ['required'],
          'due_date' => ['required','date','after:yesterday'],
          'assign_to' => ['required','numeric','exists:users,id'],
          'category' => ['required','numeric','exists:categories,id'],
          'status' => ['required','numeric','exists:statuses,id'],
        ],[
          'title.required' => 'title:You must add a task title',
          'due_date.required' => 'due:You must add a due date',
          'due_date.date' => 'due:Duew date must be a date',
          'due_date.after' => 'due:Due date must be after yesterday',
          'assign_to.required' => 'assign:You must add user id',
          'assign_to.numeric' => 'assign:You must add a number',
          'assign_to.exists' => 'assign:the user id must be existed',
         'category.required' => 'category:You must add category id',
          'category.numeric' => 'category:You must add a number',
         'category.exists' => 'category:the category id must be existed',
          'status.required' => 'status:You must add status id',
          'status.numeric' => 'status:You must add a number',
          'status.exists' => 'status:the status id must be existed',
        ]);

          if(count($v->errors()->all()) === 0) {
            
            $task = Task::where('id',$id)->update([
              'title' => strip_tags(trim($req['title'])),
              'description' => strip_tags(trim($req['description'])) ?? null ,
              'user_id' => $req['assign_to'],
              'category_id' => $req['category'],
              'status_id' => $req['status'],
              'due_date' => $req['due_date'],
              'updated_at' => \DB::raw('NOW()')
            ]);
            Cache::flush();
            return response()->json([
                'status' => 'success',
                'message' => 'Task updated Successfully',
            ]);

          }else {

            foreach($v->errors()->all() as $k=>$v) {
              if(str_contains($v,'title:')){
                self::$errors['title'] = str_ireplace('title:','',$v);
              }
              if(str_contains($v,'due:')){
                self::$errors['due_date'] = str_ireplace('due:','',$v);
              }
              if(str_contains($v,'category:')){
                self::$errors['category'] = str_ireplace('category:','',$v);
              }
              if(str_contains($v,'assign:')){
                self::$errors['assign_to'] = str_ireplace('assign:','',$v);
              }
              if(str_contains($v,'status:')){
                self::$errors['status'] = str_ireplace('status:','',$v);
              }
            }
    
            return response()->json(["status" => "error","errors" => self::$errors]);
          }
     }


     public function _deleteTask(Request $req,$id) {
            
            $task = Task::where('id',$id)->delete();
            Cache::flush();
            return response()->json([
                'status' => 'success',
                'message' => 'Task deleted Successfully',
            ]);
     }


     public function _viewDeletedTasks(){

        $tasks = Task::onlyTrashed()->with('_user:id,name','_category:id,name','_status:id,name')->get();

        return response()->json(["Deleted_Tasks" => $tasks]);

     }


     public function _viewTasks(){

        $tasks = Cache::remember('tasks',60,function () { 
         return Task::with('_user:id,name','_category:id,name','_status:id,name')
            ->latest()->paginate(5);
        });

        return response()->json(["Tasks" => $tasks])
        ->header('Cache-Control', 'public, max-age=60') 
        ->setEtag(md5(Task::count())); 

     }

     public function _restoreTask(Request $req){

      $task = Task::withTrashed()->where('id',$req['id'])->restore();
         return response()->json([
        'status' => 'success',
        'message' => 'Task restored Successfully',
        ]);
     }

}
