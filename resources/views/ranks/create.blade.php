@extends('layouts.app')
@section('content')

<!-- Card for ranks table -->
<div class="card basic-data-table mt-3 shadow-5">
    <div class="card-header bg-gradient-primary">
        Ranks Management
    </div>
    <div class="card-body">
        <!-- Button to open modal for adding a new rank -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addRankModal">Add Rank</button>

        <!-- Table displaying ranks -->
        <div class="table-responsive">
            <table class="table border-primary-table  mb-0 w-100" id="dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Rank Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ranks as $rank)
                        <tr id="rank-{{ $rank->id }}">
                            <td>{{ $rank->id }}</td>
                            <td>{{ $rank->name }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editRankModal" onclick="editRank({{ $rank->id }})"><iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon></button>
                                <button class="btn btn-danger btn-sm" onclick="deleteRank({{ $rank->id }})"> <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for adding new rank -->
<div class="modal fade" id="addRankModal" tabindex="-1" aria-labelledby="addRankModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addRankForm" action="{{ route('ranks.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRankModalLabel">Add Rank</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rankName" class="form-label">Rank Name</label>
                        <input type="text" class="form-control" id="rankName" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Rank</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal for editing existing rank -->
<div class="modal fade" id="editRankModal" tabindex="-1" aria-labelledby="editRankModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editRankForm" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRankModalLabel">Edit Rank</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editRankName" class="form-label">Rank Name</label>
                        <input type="text" class="form-control" id="editRankName" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Script for handling CRUD operations -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Function to populate the edit modal with the rank data
    function editRank(id) {
        fetch(`/ranks/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editRankName').value = data.name;
                document.getElementById('editRankForm').action = `/ranks/${id}`;
            });
    }

    // Function to delete a rank
    function deleteRank(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This will permanently delete the rank.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/ranks/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`rank-${id}`).remove();
                        Swal.fire('Deleted!', data.message, 'success');
                    }
                });
            }
        });
    }
</script>

@if(session('success'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'Okay'
        });
    </script>
@endif

@endsection
