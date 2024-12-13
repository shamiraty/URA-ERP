@extends('layouts.app')

@section('content')
<div class="container">
    <div class="main-body">
        <!-- Profile Section -->
        <div class="row justify-content-center">
            <!-- User Details Card -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-light">
                    <div class="card-body text-center">
                        <!-- Large User Icon, Centered -->
                        <div class="d-flex justify-content-center mb-4">
                        <iconify-icon icon="mingcute:user-follow-fill" class="icon text-primary text-6xl p-5 card-icon rounded-circle bg-gradient-primary d-flex justify-content-center align-items-center"></iconify-icon>
                        </div>
                        <!-- User Name, Desgination & Branch/Region with Enhanced Colors -->
                        <h4 class="text-uppercase font-weight-bold mb-2 text-primary">{{ $user->name }}</h4>
                        <p class="text-secondary text-uppercase font-weight-bold">{{ $user->designation }}</p>
                        <p class="text-muted font-size-sm mb-3 text-uppercase text-success">
                            <strong>{{ $user->branch->name ?? 'N/A' }}</strong>, <strong>{{ $user->region->name ?? 'N/A' }}</strong>
                        </p>
                        <hr>
                        <!-- List Group for Contact Information -->
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Email</span>
                                <span class="text-secondary">{{ $user->email }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Phone Number</span>
                                <span class="text-secondary">{{ $user->phone_number }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Rank</span>
                                <span class="text-secondary">{{ $user->rank->name ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Status</span>
                                <span class="text-secondary">{{ $user->status }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Role</span>
                                <span class="text-secondary">
                                    {{ $user->getRoleNames()->isNotEmpty() ? $user->getRoleNames()->join(', ') : 'No roles assigned' }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- User Information Section -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light text-primary">
                        <h6 class="font-weight-bold text-uppercase text-primary">LOCATION</h6>
                    </div>
                    <div class="card-body">
                        <!-- List Group for User Information -->
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Branch</span>
                                <span class="text-secondary font-weight-bold">{{ $user->branch->name ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Region</span>
                                <span class="text-secondary font-weight-bold">{{ $user->region->name ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Department</span>
                                <span class="text-secondary font-weight-bold">{{ $user->department->name ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>District</span>
                                <span class="text-secondary font-weight-bold">{{ $user->district->name ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Command</span>
                                <span class="text-secondary font-weight-bold">{{ $user->command->name ?? 'N/A' }}</span>
                            </li>
                        </ul>
                        <!-- Back Button -->
                        <div class="row mt-4">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-arrow-left"></i> Back to Users
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
