@extends('layouts.app')

@section('content')

<div class="container">
    <div class="page-breadcrumb d-flex align-items-center">      
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-primary d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-primary">Create User</h6>
                    <div>
                        <a href="{{ route('users.index') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Users
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="myForm" action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <!-- Personal Information Section -->
                        <div class="card mb-3 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="text-secondary">Personal Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="name">Name:</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="simu">Phone Number:</label>
                                        <input type="text" class="form-control" id="simu" name="phone_number" value="{{ old('phone_number') }}" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="password">Password:</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="confirm_password">Confirm Password:</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="rank">Rank:</label>
                                        <select class="form-control" id="rank" name="rank" required>
                                            <option value="">Select Rank</option>
                                            @foreach($ranks as $rank)
                                                <option value="{{ $rank->id }}" {{ old('rank') == $rank->id ? 'selected' : '' }}>{{ $rank->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Administrative Information Section -->
                        <div class="card mb-3 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="text-secondary">Administrative Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="status">Status:</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="role">Role:</label>
                                        <select class="form-control" id="role" name="role" required>
                                            <option value="">Select Role</option>
                                            @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="designation">Designation:</label>
                                        <input type="text" class="form-control" id="designation" name="designation" value="{{ old('designation') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Location Information Section -->
                        <div class="card mb-3 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="text-secondary">Location Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="region_id">Region:</label>
                                        <select class="form-control select2" id="region_id" name="region_id" required onchange="updateDistricts()" required>
                                            <option value="">Select Region</option>
                                            @foreach($regions as $region)
                                                <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                                    {{ $region->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="district_id">District:</label>
                                        <select class="form-control select2" id="district_id" name="district_id" required>
                                            <option value="">Select District</option>
                                            <!-- Districts will be populated here via JavaScript -->
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="department_id">Department:</label>
                                        <select class="form-control" id="department_id" name="department_id" required>
                                            <option value="">Select Department</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="command_id">Command:</label>
                                        <select class="form-control" id="command_id" name="command_id" required>
                                            <option value="">Select Command</option>
                                            @foreach($commands as $command)
                                                <option value="{{ $command->id }}" {{ old('command_id') == $command->id ? 'selected' : '' }}>
                                                    {{ $command->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="branch_id">Branch:</label>
                                        <select class="form-control" id="branch_id" name="branch_id" required>
                                            <option value="">Select Branch</option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                </div>

                <div class="card-footer">
                    <button type="submit" id="submit" class="btn btn-primary">Create User</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function updateDistricts() {
        const regionId = document.getElementById('region_id').value;
        const districtSelect = document.getElementById('district_id');
        districtSelect.innerHTML = '<option value="">Select District</option>'; // Clear existing options

        if (!regionId) return; // If no region is selected, stop here

        // Populate districts based on selected region
        @json($regions).forEach(region => {
            if (region.id == regionId) {
                region.districts.forEach(district => {
                    let option = new Option(district.name, district.id);
                    districtSelect.add(option);
                });
            }
        });
    }
</script>

@endsection
