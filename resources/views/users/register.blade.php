@extends('layouts.mainTemblate')
@section('content')
    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="text" name="name" placeholder="Your name" class="form-control">
            @error('name')
                <div class="text text-danger">
                    * {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <input type="email" name="email" placeholder="Your E-mail" class="form-control">
            @error('email')
                <div class="text text-danger">
                    * {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <input type="password" name="password" placeholder="Enter Password" class="form-control">
            @error('password')
                <div class="text text-danger">
                    * {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <input type="password" name="password_confirmation" placeholder="Re-enter password" class="form-control">
        </div>
        <div class="form-group">
            <input type="submit" value="Register" class="form-control btn btn-success">
        </div>
    </form>
@endsection
