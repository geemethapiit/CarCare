{{-- login.blade.php --}}
@extends('layout')
@section('title', 'Login')
@section('content')

    <div class="container" id="container">

        <div class="form-container sign-in">
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <h1>Sign In</h1>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <a href="#">Forget Your Password?</a>
                <button type="submit">Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">

                <div class="toggle-panel toggle-right">
                    <h1>Hello, Admin!</h1>
                    <p>Request Registration.</p>
                </div>
            </div>
        </div>
    </div>

@endsection
