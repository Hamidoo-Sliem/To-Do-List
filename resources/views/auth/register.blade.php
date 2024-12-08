@extends('layout.master')
@section('title')
  Register
@stop

@section('content')
  <div id="wrap">
    <form action="{{route('REG')}}" method="post">
      <fieldset>
        <legend>Sign Up !</legend>
          @csrf
        @error('name') <span class="error">{{$message}}</span> @enderror<br>
        <input type="text" name="name" placeholder="Name" autocomplete="off" value="{{old('name')}}"><br>
        @error('email') <span class="error">{{$message}}</span> @enderror<br>
        <input type="text" name="email" placeholder="Email" autocomplete="off" value="{{old('email')}}"><br>
        @error('password') <span class="error">{{$message}}</span> @enderror<br>
        <input type="password" name="password" placeholder="Password" autocomplete="off"><br><br>
        <input type="password" name="password_confirm" placeholder="Password Confirm" autocomplete="off"><br><br>
        <input type="submit" name="submit" value="Register">
        <a id="addNew" href="{{route('LOG.F')}}">Login</a>
    </fieldset>
    </form>
  </div>
@stop