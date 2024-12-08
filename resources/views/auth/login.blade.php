@extends('layout.master')
@section('title')
  login
@stop

@section('content')
  <div id="wrap">
    <form action="{{route('LOG')}}" method="post">
      <fieldset>
        <legend>Sign In !</legend>
        <span class="error">{{session('msg')}}</span>
          @csrf
        @error('email') <span class="error">{{$message}}</span> @enderror<br>
        <input type="text" name="email" placeholder="Email" autocomplete="off"><br>
        @error('password') <span class="error">{{$message}}</span> @enderror<br>
        <input type="password" name="password" placeholder="Password" autocomplete="off"><br><br>
        <input type="checkbox" name="remember" value="1"> Remember Me<br><br>
        <input type="submit" name="submit" value="login">
        <a id="addNew" href="{{route('REG.F')}}">Create Account</a>
    </fieldset>
    </form>
  </div>
@stop