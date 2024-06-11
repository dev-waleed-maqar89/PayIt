@extends('layouts.mainTemblate')
@section('content')
    <form action="{{ route('user.attempt') }}" method="POST">
        @csrf
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
            <input type="submit" value="Login" class="form-control btn btn-success">
        </div>
    </form>
@endsection
