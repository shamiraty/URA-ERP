@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">        
            <!-- Main Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-primary text-primary d-flex justify-content-between align-items-center">
                    <h6 class="text-primary"> Update {{ old('name', $user->name) }} </h6>
                    <a href="{{ route('users.index') }}" class="btn btn-info btn-sm">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
                
                </div>
                <div class="card-body">
                    <!-- Success or Error Message -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    <form id="editUserForm" action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Personal Information Section -->
                        <div class="card mb-4 shadow-5  mt-2">
                            <div class="card-header bg-light">
                                <h6 class="text-secondary">Personal Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="name">Name:</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="phone_number">Phone Number:</label>
                                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="password">Password:</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="rank">Rank:</label>
                                        <select class="form-control" id="rank" name="rank">
                                            <option value="" disabled>Select Rank</option>
                                            @foreach($ranks as $rank)
                                                <option value="{{ $rank->id }}" {{ old('rank', $user->rank_id) == $rank->id ? 'selected' : '' }}>
                                                    {{ $rank->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Location Section -->
                        <div class="card shadow-sm mt-2 mb-4">
                            <div class="card-header bg-light">
                                <h6 class="text-secondary">Location</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="branch_id">Branch:</label>
                                        <select class="form-control" id="branch_id" name="branch_id">
                                            <option value="" disabled>Select Branch</option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ old('branch_id', $user->branch_id) == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="district_id">District:</label>
                                        <select class="form-control" id="district_id" name="district_id">
                                            <option value="" disabled>Select District</option>
                                            @foreach($districts as $district)
                                                <option value="{{ $district->id }}" {{ old('district_id', $user->district_id) == $district->id ? 'selected' : '' }}>
                                                    {{ $district->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="region_id">Region:</label>
                                        <select class="form-control" id="region_id" name="region_id">
                                            <option value="" disabled>Select Region</option>
                                            @foreach($regions as $region)
                                                <option value="{{ $region->id }}" {{ old('region_id', $user->region_id) == $region->id ? 'selected' : '' }}>
                                                    {{ $region->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="command_id">Command:</label>
                                        <select class="form-control" id="command_id" name="command_id">
                                            <option value="" disabled>Select Command</option>
                                            @foreach($commands as $command)
                                                <option value="{{ $command->id }}" {{ old('command_id', $user->command_id) == $command->id ? 'selected' : '' }}>
                                                    {{ $command->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Access Control Section -->
                        <div class="card mb-4 mt-3 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="text-secondary">Access Control</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="department_id">Department:</label>
                                        <select class="form-control" id="department_id" name="department_id">
                                            <option value="" disabled>Select Department</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}" {{ old('department_id', $user->department_id) == $department->id ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="role">Role:</label>
                                        <select class="form-control" id="role" name="role">
                                            <option value="" disabled>Select Role</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->name }}" {{ $user->roles->first() && $user->roles->first()->name == $role->name ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="status">Status:</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    
                </div>

                <!-- Card Footer for Submit Button -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
