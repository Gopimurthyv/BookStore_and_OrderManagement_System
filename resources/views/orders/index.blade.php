@extends('layouts.order')
@section('title', 'Order List')
@section('heading','Order List')

@section('content')
<div class="container">
    <div class="mb-4">
        <h2 class="fw-bold">Customer Orders</h2>
        <div class="text-end">
            <a href="{{ route('book.index') }}" class="btn btn-sm btn-danger">Back to Book List</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif


    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Order Date</th>
                <th>Total Price (₹)</th>
                <th>Books Ordered</th>
            </tr>
        </thead>
        <tbody>
        @forelse($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->customer->name }}</td>
                <td>{{ date('M d , Y', strtotime($order->order_date))}}</td>
                <td>{{ number_format($order->total_price, 2) }}</td>
                <td>
                    <ul class="mb-0 ps-3">
                        @foreach($order->items as $item)
                            @if ($item->book)
                                <li>{{ $item->book->title }} (Qty: {{ $item->quantity }})</li>
                            @else
                                <li class="text-danger">[Deleted Book #{{ $item->book_id }}] (Qty : {{ $item->quantity }})</li>
                            @endif
                        @endforeach
                    </ul>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No orders found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $orders->links() }}
</div>
@endsection
