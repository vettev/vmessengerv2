@extends('layouts.master')

@section('content')
    <h1 class="site-title">
        VMsg <span class="glyphicon glyphicon-envelope"></span>
    </h1>
    <!--<div class="col-md-7">
        <div class="register-section">
            <h3>Register new account</h3>
            <form action="#">
                <div class="form-group">
                    <label for="name">Your name</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Your email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password2">Re-Password</label>
                    <input type="password" id="password2" name="password2" class="form-control" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-5">
        <div class="login-section">
            <h3>Log in</h3>
            <form action="#">
                <div class="form-group">
                    <label for="email">Your email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
    -->
    @include('auth.login')
    @include('auth.register')
@endsection