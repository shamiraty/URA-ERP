{{-- resources/views/branches/index.blade.php --}}

@extends('layouts.app')

@section('content')

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
                <h6 class="fw-semibold mb-0">Branch</h6>
                <ul class="d-flex align-items-center gap-2">
                  <li class="fw-medium">
                    <a href="#" class="d-flex align-items-center gap-1 hover-text-primary">
                      <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                      Branch
                    </a>
                  </li>
                  <li>-</li>
                  <li class="fw-medium">Branch List</li>
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
                        <h5 class="card-title mb-0"> <a href="{{ route('branches.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0">
                            <i class="bx bxs-plus-square"></i> Create New Branch
                        </a></h5>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                    <table class="table border-primary-table mb-0" id="dataTable" data-page-length='10'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Branch Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($branches as $branch)
                    <tr>
                        <td>{{ $loop->iteration }}</td> <!-- Automatically displays the row number -->
                        <td>{{ $branch->name }}</td>
                        <td>
                            <a href="{{ route('branches.edit', $branch) }}" class="btn btn-warning btn-sm">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('branches.show', $branch) }}" class="btn btn-info btn-sm">
                                <i class="fa fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
