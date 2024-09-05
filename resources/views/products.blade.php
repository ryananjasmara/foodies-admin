@extends('layouts.app')

@section('title', 'Product List')

@section('content')
<div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Product List</li>
        </ol>
    </nav>
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createProductModal">
        Create New Product
    </button>
    <table class="table table-bordered table-hover table-light-blue">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->type }}</td>
                    <td>{{ $product->qty }}</td>
                    <td>{{ formatRupiah($product->price) }}</td>
                    <td>
                        <img src="{{ $product->image_url }}" alt="Product Image" class="img-thumbnail product-image"
                            width="50" height="50" onclick="showImageModal('{{ $product->image_url }}')">
                    </td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                            data-target="#editProductModal" data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                            data-type="{{ $product->type }}" data-qty="{{ $product->qty }}"
                            data-price="{{ $product->price }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#deleteProductModal" data-id="{{ $product->id }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No Product Data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProductModalLabel">Create New Product</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('products.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="Food">Food</option>
                            <option value="Beverage">Beverage</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="qty" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="qty" name="qty" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image" required accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('products.update', ':id') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="edit-name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-type" class="form-label">Type</label>
                        <select class="form-control" id="edit-type" name="type" required>
                            <option value="Food">Food</option>
                            <option value="Beverage">Beverage</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-qty" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="edit-qty" name="qty" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="edit-price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="edit-image" name="image" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel">Delete Product</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product?
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

<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagePreviewModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="Product Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            window.showImageModal = function (imageUrl) {
                $('#previewImage').attr('src', imageUrl);
                $('#imagePreviewModal').modal('show');
            }

            $('#editProductModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var name = button.data('name');
                var type = button.data('type');
                var qty = button.data('qty');
                var price = button.data('price');

                var modal = $(this);
                modal.find('#edit-id').val(id);
                modal.find('#edit-name').val(name);
                modal.find('#edit-type').val(type);
                modal.find('#edit-qty').val(qty);
                modal.find('#edit-price').val(price);

                var action = '{{ route("products.update", ":id") }}';
                action = action.replace(':id', id);
                modal.find('form').attr('action', action);
            });

            $('#deleteProductModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var action = '{{ route("products.delete", ":id") }}';
                action = action.replace(':id', id);

                var modal = $(this);
                modal.find('#delete-form').attr('action', action);
            });
        });
    </script>
@endpush
@endsection