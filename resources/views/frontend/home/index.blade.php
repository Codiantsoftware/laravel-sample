
@extends('layouts.frontend.app')
@section('title', 'Home')
@section('content')

<a href="{{route('login')}}" > Login</a>
<a href="{{route('user.signup-form')}}" > Register</a>
@endsection
