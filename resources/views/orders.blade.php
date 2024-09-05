@extends('layouts.app')

@section('title', 'Order List')

@section('content')
<div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Order List</li>
        </ol>
    </nav>
    <div class="mb-3">
        <a href="{{ route('orders.export') }}" class="btn btn-primary">Export Order Data</a>
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
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No Order Data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection