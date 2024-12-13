{{-- resources/views/representatives/index.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    {{-- <h1>Representatives</h1>
    <a href="{{ route('representatives.create') }}" class="btn btn-primary">Add New Representative</a>
    <table class="table"> --}}


        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0"> Representatives</h6>
            <ul class="d-flex align-items-center gap-2">
              <li class="fw-medium">
                <a href="#" class="d-flex align-items-center gap-1 hover-text-primary">
                  <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                  Representatives
                </a>
              </li>
              <li>-</li>
              <li class="fw-medium">Representatives List</li>
            </ul>
          </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card basic-data-table">
                <div class="card-header">
                    <h5 class="card-title mb-0"> <a href="{{ route('representatives.create') }} " class="btn btn-primary radius-30 mt-2 mt-lg-0">
                        <i class="bx bxs-plus-square"></i> Add New Representative
                    </a></h5>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                <table class="table border-primary-table mb-0" id="dataTable" data-page-length='10'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Branch</th>
                <th>District</th>
                <th>Region</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($representatives as $representative)
                <tr>
                    <td>{{ $representative->id }}</td>
                    <td>{{ $representative->user->name }}</td>
                    <td>{{ $representative->department->name }}</td>
                    <td>{{ $representative->branch->name }}</td>
                    <td>{{ $representative->district->name }}</td>
                    <td>{{ $representative->region->name }}</td>
                    <td>
                        <a href="{{ route('representatives.show', $representative->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('representatives.edit', $representative->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('representatives.destroy', $representative->id) }}" method="POST" style="display: inline-block;">
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
@endsection
