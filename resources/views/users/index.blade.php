{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h1>Users</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary">Add New User</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone_number }}</td>
                <td>{{ $user->status }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info">Edit</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection --}}
@extends('layouts.app')
@section('content')
<style>
    #example2 th, #example2 td {
        border: 1px solid #dee2e6;
        padding: 10px; /* Increased padding for better readability */
        text-align: left;
    }
    /* Add space between the export buttons and the table */
    .dt-buttons {
        margin-bottom: 15px; /* Adjust this value as needed */
    }
    /* Adjusting the table for better responsiveness */
    .table-responsive {
        overflow-x: auto; /* Enables horizontal scrolling on smaller screens */
    }
    /* Optional: Add hover effects for rows */
    #example2 tbody tr:hover {
        background-color: #f5f5f5; /* Change the color on hover */
    }
</style>
<div class="container">
    <div class="page-breadcrumb d-flex align-items-center mb-4">
        <div class="breadcrumb-title pe-3">Users</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('enquiries.index') }}">
                            <i class="bx bx-home-alt"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">System Users</li>
                </ol>
            </nav>
        </div>
    </div>

    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm mb-3">
        <i class="fas fa-user-plus"></i> Add New User
    </a>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table border-primary-table mb-0" id="dataTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                           {{-- <th>Designation</th>--}}
                            <th>Rank</th>
                            <th>Status</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            {{-- <td>{{ $user->designation }}</td>--}}
                            <td>{{ $user->rank }}</td>
                            <td><span class="bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">{{ $user->status }}</span></td>
                            <td>{{ $user->phone_number }}</td>
                            <td>
                                @if($user->getRoleNames()->isNotEmpty())
                                    {{ $user->getRoleNames()->join(', ') }}
                                @else
                                    No roles assigned
                                @endif
                            </td>
                            <td class="text-center">
    <!-- Edit Button -->
    <a href="{{ route('users.edit', $user->id) }}" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
        <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
    </a>
</td>
                            <td class="text-center">
    <!-- Delete Button -->
    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle" onclick="return confirm('Are you sure you want to delete this user?')">
            <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
        </button>
    </form>
</td>
                            <td class="text-center">
    <div class="d-flex align-items-center gap-10 justify-content-center">
        <!-- View Button -->
        <a href="{{ route('users.show', $user->id) }}" class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
            <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
        </a>
    </div>
</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection

