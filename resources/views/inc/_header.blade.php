<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
 <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="author" content="Hamdi">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="theme-color" content="#ffffff">
    <meta name="google-site-verification" content="" />
    <meta name="csrf-token" content="{{csrf_token()}}">
<title>@yield('title')</title>
<!--link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"-->
<link rel="stylesheet" href="{{asset('css/font/bootstrap-icons.min.css')}}">
<style>
:root {
   --themeColor:#888; 
}
* {
   box-sizing: border-box;
}
html,body{
margin:0;
padding:0;
scroll-behavior: smooth;
}
::placeholder {
    color: gray;
}
header {
    background-color:var(--themeColor);
    height:50px;
    text-align:center;
    padding-top:15px;
}
header #log a {
  text-decoration:none;
  background-color:#444;
  color:#fff;
  border-radius:10px;
  padding:10px;
}
div#wrap {
  max-width:800px;
  margin:40px auto;
}
fieldset {
  background-color:#ddd;
}
fieldset input[type='text'],fieldset input[type='password'] {
  outline:none;
  padding:6px;
  width:250px;
}
fieldset input[type='submit']{
  cursor:pointer;
  padding:6px 14px;
}
span.error{
  color:#ff000090;
}
span.success{
  color:darkgreen;
}
div.reg {
  text-align:center;
  font-weight:bold;
}
fieldset textarea {
  outline:none;
  padding:6px;
}
table{
  width:100%;
  margin-top:20px;
  border-collapse:collapse;
}
table th {
  background-color:var(--themeColor);
  color:#fff;
}
table td {
 padding:7px;
}
table tbody tr:nth-child(odd) {
  background-color:#ddd;
}
table tbody tr:nth-child(even) {
  background-color:#eee;
}
table tbody tr:hover {
  background-color:#33333370;
}
a#addNew {
  display:inline-block;
  float:right;
  text-decoration:none;
  background-color:#666;
  color:#fff;
  border-radius:10px;
  padding:10px;
}
h4::after {
  content:"";
  display:block;
  clear:both;
}
</style>
  @yield('styles')
</head>

<body>
    <header>
      @auth 
        <div id="log">
          Welcome : {{\Auth::user()->name}} &nbsp;&nbsp; <a href="{{route('LOGOUT')}}">Sign Out</a>
        </div>
      @endauth
    </header>