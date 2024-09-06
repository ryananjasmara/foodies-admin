@extends('layouts.app')

@section('title', 'Foodies Admin - Order List')

@section('content')
<div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Order List</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        @if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->hasPermission('create_orders'))
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createOrderModal">
                Create New Order
            </button>
        @endif
        @if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->hasPermission('export_orders'))
            <div class="mb-3">
                <a href="{{ route('orders.export') }}" class="btn btn-success">Export Order Data</a>
            </div>
        @endif
    </div>
    <table class="table table-bordered table-hover table-light-blue">
        <thead class="thead-light">
            <tr>
                <th>Order ID</th>
                <th>Product Name</th>
                <th>User Name</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Order Date</th>
                @if (Auth::guard('admin')->check() && (Auth::guard('admin')->user()->hasPermission('edit_orders') || Auth::guard('admin')->user()->hasPermission('delete_orders')))
                    <th>Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->product->name }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->qty }}</td>
                    <td>{{ formatRupiah($order->total) }}</td>
                    <td>{{ formatDate($order->created_at) }}</td>
                    @if (Auth::guard('admin')->check() && (Auth::guard('admin')->user()->hasPermission('edit_orders') || Auth::guard('admin')->user()->hasPermission('delete_orders')))
                        <td>
                            @if (Auth::guard('admin')->user()->hasPermission('edit_orders'))
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                    data-target="#editOrderModal" data-id="{{ $order->id }}"
                                    data-product_id="{{ $order->product_id }}" data-user_id="{{ $order->user_id }}"
                                    data-qty="{{ $order->qty }}" data-total="{{ $order->total }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            @endif
                            @if (Auth::guard('admin')->user()->hasPermission('delete_orders'))
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#deleteOrderModal" data-id="{{ $order->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            @endif
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No Order Data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="modal fade" id="createOrderModal" tabindex="-1" aria-labelledby="createOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createOrderModalLabel">Create New Order</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('orders.create') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product</label>
                        <select class="form-control" id="product_id" name="product_id" required>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="user_id" class="form-label">User</label>
                        <select class="form-control" id="user_id" name="user_id" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="qty" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="qty" name="qty" required>
                    </div>
                    <div class="mb-3">
                        <label for="total" class="form-label">Total</label>
                        <input type="number" class="form-control" id="total_display" disabled>
                        <input type="hidden" id="total" name="total">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOrderModalLabel">Edit Order</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('orders.update', ':id') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-product_id" class="form-label">Product</label>
                        <select class="form-control" id="edit-product_id" name="product_id" required>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-user_id" class="form-label">User</label>
                        <select class="form-control" id="edit-user_id" name="user_id" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-qty" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="edit-qty" name="qty" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-total" class="form-label">Total</label>
                        <input type="number" class="form-control" id="edit-total_display" disabled>
                        <input type="hidden" id="edit-total" name="total">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteOrderModal" tabindex="-1" aria-labelledby="deleteOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteOrderModalLabel">Delete Order</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this order?
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
        function calculateTotal(modal) {
            var productPrice = modal.find('select[name="product_id"] option:selected').data('price');
            var quantity = modal.find('input[name="qty"]').val();
            var total = productPrice * quantity;

            modal.find('input[name="total"]').val(total);
            modal.find('input[id$="total_display"]').val(total);
        }

        function resetForm(modal) {
            modal.find('form')[0].reset();
            modal.find('input[name="total"]').val('');
            modal.find('input[id$="total_display"]').val('');
        }

        $('#createOrderModal').on('change input', 'select[name="product_id"], input[name="qty"]', function () {
            calculateTotal($('#createOrderModal'));
        });

        $('#editOrderModal').on('change input', 'select[name="product_id"], input[name="qty"]', function () {
            calculateTotal($('#editOrderModal'));
        });

        $('#editOrderModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var product_id = button.data('product_id');
            var user_id = button.data('user_id');
            var qty = button.data('qty');
            var total = button.data('total');

            var modal = $(this);
            modal.find('#edit-product_id').val(product_id);
            modal.find('#edit-user_id').val(user_id);
            modal.find('#edit-qty').val(qty);
            modal.find('#edit-total_display').val(total);
            modal.find('input[name="total"]').val(total);

            var action = '{{ route("orders.update", ":id") }}';
            action = action.replace(':id', id);
            modal.find('form').attr('action', action);

            calculateTotal(modal);
        });

        $('#createOrderModal, #editOrderModal').on('hidden.bs.modal', function () {
            resetForm($(this));
        });

        $('#deleteOrderModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var action = '{{ route("orders.delete", ":id") }}';
            action = action.replace(':id', id);

            var modal = $(this);
            modal.find('#delete-form').attr('action', action);
        });
    </script>
@endpush
@endsection