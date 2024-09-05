@extends('layouts.app')

@section('title', 'User List')

@section('content')
<div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">User List</li>
        </ol>
    </nav>
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createUserModal">
        Create New User
    </button>
    <table class="table table-bordered table-hover table-light-blue">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->name }}</td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                            data-target="#editUserModal" data-id="{{ $user->id }}" data-username="{{ $user->username }}"
                            data-name="{{ $user->name }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#deleteUserModal" data-id="{{ $user->id }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No User Data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Create New User</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.create') }}" method="POST">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.update', ':id') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-username">Username</label>
                        <input type="text" class="form-control" id="edit-username" name="username" value="" required
                            autocomplete="new-username">
                    </div>
                    <div class="mb-3">
                        <label for="edit-password">Password</label>
                        <input type="password" class="form-control" id="edit-password" name="password" autocomplete="new-password">
                    </div>
                    <div class="mb-3">
                        <label for="edit-name">Name</label>
                        <input type="text" class="form-control" id="edit-name" name="name" value="" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user?
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
        $('#editUserModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var username = button.data('username');
            var name = button.data('name');

            var modal = $(this);
            modal.find('#edit-id').val(id);
            modal.find('#edit-username').val(username);
            modal.find('#edit-name').val(name);

            var action = '{{ route("users.update", ":id") }}';
            action = action.replace(':id', id);
            modal.find('form').attr('action', action);
        });

        $('#deleteUserModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var action = '{{ route("users.delete", ":id") }}';
            action = action.replace(':id', id);

            var modal = $(this);
            modal.find('#delete-form').attr('action', action);
        });
    </script>
@endpush
@endsection