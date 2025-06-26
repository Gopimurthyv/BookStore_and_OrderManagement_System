@extends('layouts.form')
@section('title','book details')
@section('heading','Book Details')

@section('content')
<div class="container">
    <h2 class="mb-4 text-primary fw-bold">{{ $book->title }}</h2>

    <div class="row">
        <div class="col-md-4">
            <img src="{{ asset('storage/images/' . $book->image) }}" class="img-fluid rounded" width="200" height="200" alt="Book Cover">
        </div>
        <div class="col-md-8">
            <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
            <p><strong>Book ID:</strong> {{ $book->book_id }}</p>
            <p><strong>Language:</strong> {{ $book->language }}</p>
            <p><strong>Price:</strong> ₹{{ number_format($book->price, 2) }}</p>
            <p><strong>Published Date:</strong> {{ $book->published_date ?? 'N/A' }}</p>
            <p><strong>Supplier:</strong> {{ $book->supplier->name ?? 'N/A' }}</p>
            <p><strong>Categories:</strong> {{ implode(', ', json_decode($book->categories, true)) }}</p>
            <p><strong>Total Stock:</strong> {{ $totalStock }}</p>
            <p><strong>Total Sold:</strong> {{ $totalSold }}</p>
        </div>
    </div>

    <hr class="my-2">

    <h4>Authors</h4>
    <ul class="d-flex justify-content-start gap-5">
        @foreach($book->authors as $author)
            <li>{{ $author->author_name }} ({{ $author->author_email }})</li>
        @endforeach
    </ul>
    <hr>
    <h4>Stock by Location</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Store Location</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach($book->stocks as $stock)
                <tr>
                    <td>{{ $stock->store_location }}</td>
                    <td>{{ $stock->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="text-end">
        <a href="{{ route('book.index') }}" class="btn btn-danger" >Back to List</a>
    </div>
</div>
@endsection
