@extends('layout.master')
@section('title')
  Tasks
@stop

@section('content')
  <div id="wrap">
    @if(request()->is('task'))
    <form action="{{route('N.T')}}" method="post">
      <fieldset>
        <legend>New Task !</legend>
        @session('msg')
        <span class="success">{{$value}}</span>
        @endsession
          @csrf
        @error('title') <span class="error">{{$message}}</span> @enderror<br>
        <input type="text" name="title" placeholder="Task Title" autocomplete="off"><br><br>
        Assign To : <select name="assign">
        @foreach($users as $u)
           <option value="{{$u->id}}">{{$u->name}}</option>
           @endforeach
        </select>
        &nbsp;&nbsp; Category : <select name="category">
        @foreach($category as $c)
           <option value="{{$c->id}}">{{$c->name}}</option>
           @endforeach
        </select><br>
        @error('description') <span class="error">{{$message}}</span> @enderror<br>
         <textarea name="description"  cols="31" rows="5" placeholder="Task Description" ></textarea><br>
         @error('due_date') <span class="error">{{$message}}</span> @enderror<br>
         Due Date : <input type="date" name="due_date"><br><br>
        <input type="submit" name="submit" value="Add New Task">
    </fieldset>
    </form>
    @elseif(request()->is('task/*'))
    <form action="{{route('U.T',['id' => $task->id])}}" method="post">
      <fieldset>
        <legend>Update Task !</legend>
        <span class="success">{{session('msg')}}</span>
          @csrf
        @error('title') <span class="error">{{$message}}</span> @enderror<br>
        <input type="text" name="title" placeholder="Task Title" autocomplete="off" value="{{$task->title}}"><br><br>
        Assign To : <select name="assign">
        @foreach($users as $u)
           <option value="{{$u->id}}" @if($task->user_id == $u->id) selected @endif>{{$u->name}}</option>
           @endforeach
        </select>
        &nbsp;&nbsp; Category : <select name="category">
        @foreach($category as $c)
           <option value="{{$c->id}}" @if($task->category_id == $c->id) selected @endif>{{$c->name}}</option>
           @endforeach
        </select>
        &nbsp;&nbsp; Status : <select name="status">
        @foreach($status as $s)
           <option value="{{$s->id}}" @if($task->status_id == $s->id) selected @endif>{{$s->name}}</option>
           @endforeach
        </select><br>
        @error('description') <span class="error">{{$message}}</span> @enderror<br>
         <textarea name="description"  cols="31" rows="5" placeholder="Task Description" >{{$task->description}}</textarea><br>
         @error('due_date') <span class="error">{{$message}}</span> @enderror<br>
         Due Date : <input type="date" name="due_date" value="{{$task->due_date}}"><br><br>
         
        <input type="submit" name="submit" value="Update Task">
    </fieldset>
    </form>
    @endif
     <h4>To-Do List (Tasks) 
      @if(request()->is('task/*')) <a id="addNew" href="{{route('HOME')}}">Add New Task</a> @endif
    </h4>
     @if(count($tasks) != 0)
      <div id="opt">
        <input type="search" id="search" placeholder="Title Or Description" autocomplete="off">
      <select id="status">
      <option value="-1">All status</option>
        @foreach($status as $st)
           <option value="{{$st->id}}">{{$st->name}}</option>
           @endforeach
        </select>
      </div>
    <table id="tasks">
      <thead>
      <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Assignee</th>
        <th>Category</th>
        <th>Status</th>
        <th>Due Date</th>
        <th>&nbsp;</th>
      </tr>
      </thead>
      <tbody>
        @foreach($tasks as $v)
        <tr>
          <td>{{$v->title}}</td>
          <td>{{$v->description}}</td>
          <td>{{$v->_user->name}}</td>
          <td>{{$v->_category->name}}</td>
          <td>{{$v->_status->name}}</td>
          <td>{{$v->due_date}}</td>
          <td><a href="{{route('HOME',['id' => $v->id])}}" title="Edit"><i class="bi bi-pen-fill"></i></a> 
          <a href="{{route('D.T',['id' => $v->id])}}" title="Delete"><i class="bi bi-archive-fill"></i></a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
     <p>There is no tasks</p>
    @endif
  </div>
@stop

@section('scripts')
   <script>
     $(window).on('load',function(){
       $('input#search').on('input',function(){
          $("table#tasks > tbody").html("Loading ...");
          setTimeout(()=>{
            $.get("{{route('SE.T')}}",{"search":$(this).val()},(data)=>{
             $("table#tasks > tbody").html(data);
          });
          },2000);
       });

       $('select#status').on('change',function(){
          $("table#tasks > tbody").html("Loading ...");
          setTimeout(()=>{
            $.get("{{route('FI.T')}}",{"filter":$(this).val()},(data)=>{
             $("table#tasks > tbody").html(data);
          });
          },2000);
       });

     });
   </script>
@endsection