@extends('layouts.auth')
@section('page-title', 'SignIn')
@section('content')
    <div class="card mt-4 card-bg-fill">

        <div class="card-body p-4">
            <div class="text-center mt-2">
                <h5 class="text-primary">Lock Screen</h5>
                <p class="text-muted">Enter your password to unlock the screen!</p>
            </div>
            <div class="user-thumb text-center">
                <img src="{{ asset('assets/theme/images/users/avatar-1.jpg') }}"
                    class="rounded-circle img-thumbnail avatar-lg material-shadow" alt="thumbnail">
                <h5 class="font-size-15 mt-3">{{ auth()->user()->name }}</h5>
            </div>
            <div class="p-2 mt-4">
                <form action="{{ url()->previous() }}">
                    <div class="mb-3">
                        <label class="form-label" for="userpassword">Password</label>
                        <input type="password" class="form-control" id="userpassword" placeholder="Enter password" required>
                    </div>
                    <div class="mb-2 mt-4">
                        <button class="btn btn-success w-100" type="submit">Unlock</button>
                    </div>
                </form><!-- end form -->

            </div>
        </div>
        <!-- end card body -->
    </div>
    <!-- end card -->

    <div class="mt-4 text-center">
        <p class="mb-4">Not you ? return <a href="{{ route('login') }}"
                class="fw-semibold text-primary text-decoration-underline"> Signin </a> </p>
    </div>

@endsection
