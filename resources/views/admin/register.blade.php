@extends('layout')
@section('title', 'Admin Registration')
@section('content')

    <div class="container" id="container">

        <div class="form-container sign-in">
            <form action="{{ route('admin.register') }}" method="POST">
                @csrf
                <h1>Admin Registration</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

                <button type="submit">Register</button>
            </form>
        </div>

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                    <h1>Welcome Back!</h1>
                    <p>Request Registration</p>
                </div>
            </div>
        </div>
    </div>

@endsection
