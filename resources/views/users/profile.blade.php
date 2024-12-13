@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- User Profile Column (Left) -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-gradient-primary font-weight-bold">{{ __('User Profile') }}</div>
                <div class="card-body">
                    <!-- User Details List Group -->
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>{{ __('Name') }}</strong>
                            <span>{{ $user->name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>{{ __('Email Address') }}</strong>
                            <span>{{ $user->email }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>{{ __('Phone Number') }}</strong>
                            <span>{{ $user->phone_number }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>{{ __('Rank') }}</strong>
                            <span>{{ $user->rank->name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>{{ __('Designation') }}</strong>
                            <span>{{ $user->designation ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>{{ __('Branch') }}</strong>
                            <span>{{ $user->branch->name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>{{ __('Department') }}</strong>
                            <span>{{ $user->department->name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>{{ __('District') }}</strong>
                            <span>{{ $user->district->name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>{{ __('Region') }}</strong>
                            <span>{{ $user->region->name ?? 'N/A' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Change Password Column (Right) -->
        <div class="col-md-6 mt-4 mt-md-0">
            <div class="card">
                <div class="card-header bg-warning text-white font-weight-bold">{{ __('Change Password') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update-password') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                            <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required>
                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">{{ __('New Password') }}</label>
                            <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required>
                            @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">{{ __('Confirm New Password') }}</label>
                            <input id="new_password_confirmation" type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation" required>
                            @error('new_password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-sm">{{ __('Update Password') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
