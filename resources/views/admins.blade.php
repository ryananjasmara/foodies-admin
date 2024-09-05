@extends('layouts.app')

@section('title', 'Admin List')

@section('content')
<div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Admin List</li>
        </ol>
    </nav>
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createAdminModal">
        Create New Admin
    </button>
    <table class="table table-bordered table-hover table-light-blue">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Name</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($admins as $admin)
                <tr>
                    <td>{{ $admin->id }}</td>
                    <td>{{ $admin->username }}</td>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->role }}</td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                            data-target="#editAdminModal" data-id="{{ $admin->id }}" data-username="{{ $admin->username }}"
                            data-name="{{ $admin->name }}" data-role="{{ $admin->role }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#deleteAdminModal" data-id="{{ $admin->id }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No Admin Data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="modal fade" id="createAdminModal" tabindex="-1" aria-labelledby="createAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAdminModalLabel">Create New Admin</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admins.create') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="" required
                            autocomplete="new-username">
                    </div>
                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required
                            autocomplete="new-password">
                    </div>
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="Super Admin">Super Admin</option>
                            <option value="Admin">Admin</option>
                            <option value="Read Only">Read Only</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAdminModalLabel">Edit Admin</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admins.update', ':id') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-username">Username</label>
                        <input type="text" class="form-control" id="edit-username" name="username" value="" required
                            autocomplete="new-username">
                    </div>
                    <div class="mb-3">
                        <label for="edit-password">Password</label>
                        <input type="password" class="form-control" id="edit-password" name="password"
                            autocomplete="new-password">
                    </div>
                    <div class="mb-3">
                        <label for="edit-name">Name</label>
                        <input type="text" class="form-control" id="edit-name" name="name" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-role">Role</label>
                        <select class="form-control" id="edit-role" name="role" required>
                            <option value="Super Admin">Super Admin</option>
                            <option value="Admin">Admin</option>
                            <option value="Read Only">Read Only</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteAdminModal" tabindex="-1" aria-labelledby="deleteAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAdminModalLabel">Delete Admin</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this admin?
            </div>
            <div class="modal-footer">
                <form id="delete-form" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $('#editAdminModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var username = button.data('username');
            var name = button.data('name');
            var role = button.data('role');

            var modal = $(this);
            modal.find('#edit-id').val(id);
            modal.find('#edit-username').val(username);
            modal.find('#edit-name').val(name);
            modal.find('#edit-role').val(role);

            var action = '{{ route("admins.update", ":id") }}';
            action = action.replace(':id', id);
            modal.find('form').attr('action', action);
        });

        $('#deleteAdminModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var action = '{{ route("admins.delete", ":id") }}';
            action = action.replace(':id', id);

            var modal = $(this);
            modal.find('#delete-form').attr('action', action);
        });
    </script>
@endpush
@endsection