@extends('layouts.app')

@section('content')
    <div class="app-topbar">
        <div>
            <h6 class="mb-1">Profile & Security</h6>
            <small class="text-muted">Update your personal details and security settings.</small>
        </div>
    </div>

    <div class="card-elevated mb-4">
        <h5 class="mb-3">Profile Information</h5>
        @if (session('status') === 'profile-updated')
            <div class="alert alert-success">Profile updated successfully.</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
            </div>
            <div class="mt-3">
                <button class="btn btn-primary" type="submit">Update Profile</button>
            </div>
        </form>
    </div>

    <div class="card-elevated mb-4">
        <h5 class="mb-3">Update Password</h5>
        @if (session('status') === 'password-updated')
            <div class="alert alert-success">Password updated successfully.</div>
        @endif
        @if ($errors->updatePassword->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->updatePassword->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Current Password</label>
                    <input class="form-control" type="password" name="current_password" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">New Password</label>
                    <input class="form-control" type="password" name="password" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Confirm Password</label>
                    <input class="form-control" type="password" name="password_confirmation" required>
                </div>
            </div>
            <div class="mt-3">
                <button class="btn btn-outline-primary" type="submit">Update Password</button>
            </div>
        </form>
    </div>

    <div class="card-elevated">
        <h5 class="mb-3">Delete Account</h5>
        @if ($errors->userDeletion->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->userDeletion->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')
            <p class="text-muted">This action is permanent and will remove your account.</p>
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input class="form-control" type="password" name="password" required>
            </div>
            <button class="btn btn-outline-danger" type="submit">Delete Account</button>
        </form>
    </div>
@endsection
