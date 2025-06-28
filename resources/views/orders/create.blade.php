@extends('layouts.form')
@section('title','Order')
@section('heading','Place a New Book Order')

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@section('content')
<div class="container">
    <form method="POST" action="{{ route('order.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-bold">Select Customer:</label>
            <select name="customer_id" class="form-select" required>
                <option value="" disabled selected>Choose a customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>

        <hr class="my-4">
        <h5 class="fw-bold text-primary">Order Books</h5>

        <div id="bookRows">
            <div class="row g-2 align-items-end mb-2 book-row">
                <div class="col-md-6">
                    <label class="form-label">Select Book:</label>
                    <select name="book_id[]" class="form-select" required>
                        <option value="" disabled selected>Choose a book</option>
                        @foreach($books as $book)
                            @php
                                $stockQty = $book->stocks->sum('quantity');
                            @endphp
                            <option value="{{ $book->id }}" {{ $stockQty == 0 ? 'disabled' : '' }}>{{ $book->title }} (Stock: {{ $stockQty }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Quantity:</label>
                    <input type="number" name="quantity[]" class="form-control" placeholder="Qty" min="1" required>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-danger mt-4" type="button" onclick="removeRow(this)">Remove</button>
                </div>
            </div>
        </div>

        <div class="mb-3  text-end">
            <button type="button" class="btn btn-sm btn-secondary" onclick="addRow()">+ Add Another Book</button>
        </div>

        <button type="submit" class="btn btn-primary">🛒 Place Order</button>

        <a href="{{ route('book.index') }}" class="btn me-2 btn-danger">Back</a>

    </form>
</div>

<script>
function addRow() {
    const row = document.querySelector('#bookRows .book-row').cloneNode(true);
    row.querySelectorAll('input').forEach(input => input.value = '');
    document.getElementById('bookRows').appendChild(row);
}

function removeRow(btn) {
    const totalRows = document.querySelectorAll('#bookRows .book-row').length;
    if (totalRows > 1) {
        btn.closest('.book-row').remove();
    }
}
</script>
@endsection
