<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\{Task,User,Category,Status};

class TaskController extends Controller
{
    public function __construct() {
        $this->middleware('guest:web');
     }
   
     public function _index($id = null){

        if(isset($id) && !is_null($id)){
          $task = Task::findOrFail($id);
        }else {
          $task = null;
        }
        $tasks = Task::with('_user','_category','_status')->latest()->get();
        $users = User::select('id','name')->get();
        $category = Category::select('id','name')->get();
        $status = Status::select('id','name')->get();
        $data =[
         "task" => $task,
         "tasks" => $tasks,
         "users" => $users,
         'category' => $category,
         'status' => $status
        ];
        return view('tasks',$data);
     }


     public function _addNewTask(Request $req) {

        $req->validate([
            'title' => ['required','unique:tasks'],
            'due_date' => ['required','after:yesterday']
          ],[
            'title.required' => 'You must add a task title',
            'title.unique' => 'This task is already existed',
            'due_date.required' => 'You must add a due date',
            'due_date.after' => 'Due date must be after yesterday',
          ]);
            
            $task = Task::insert([
                'title' => strip_tags(trim($req['title'])),
                'description' => strip_tags(trim($req['description'])) ?? null ,
                'user_id' => $req['assign'],
                'category_id' => $req['category'],
                'status_id' => 1,
                'due_date' => $req['due_date'],
                'created_at' => \DB::raw('NOW()')
            ]);
          
            return back()->with("msg","The Task Created Successfully");
     }


     public function _updateTask(Request $req) {

      $req->validate([
          'title' => ['required'],
          'due_date' => ['required','after:yesterday']
        ],[
          'title.required' => 'You must add a task title',
          'due_date.required' => 'You must add a due date',
          'due_date.after' => 'Due date must be after yesterday',
        ]);
          
          $task = Task::where('id',$req->query('id'))->update([
              'title' => strip_tags(trim($req['title'])),
              'description' => strip_tags(trim($req['description'])) ?? NULL ,
                'user_id' => $req['assign'],
                'category_id' => $req['category'],
                'status_id' => $req['status'],
                'due_date' => $req['due_date'],
              'updated_at' => \DB::raw('NOW()')
          ]);
          
          return back()->with("msg","The Task Updated Successfully");

   }

   public function _deleteTask($id) {
      Task::where('id',$id)->delete();
      return back();
   }

   public function _search(Request $req){
     $tasks = Task::with('_user','_category','_status')
     ->where('title','like','%'.$req['search'].'%')
     ->orWhere('description','like','%'.$req['search'].'%')
     ->latest()->get();

     return view('_data',['tasks'=>$tasks]);
   }

   public function _filter(Request $req){
    $tasks = Task::with('_user','_category','_status')
    ->where(function($q) use ($req){
      if($req['filter'] != '-1'){
        $q->where('status_id',$req['filter']);
      }
    })->latest()->get();

    return view('_data',['tasks'=>$tasks]);
  }


}
