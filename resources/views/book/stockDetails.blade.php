@extends('layouts.index')
@section('title','stock details')
@section('heading', 'Stock Details')

@section('table')
    <section class="table-responsive">
        <div class="d-flex text-center align-middle ">
            <table class="table table-bordered mb-3">
                <thead class="table-primary">
                    <tr>
                        <th>Title</th>
                        <th>ISBN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $books->title }}</td>
                        <td>{{ $books->isbn }}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr class="table-primary">
                        <th>Stock Location</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stocks as $stock)
                        <tr>
                            <td>{{ $stock->store_location }}</td>
                            <td>{{ $stock->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <table class="table table-bordered text-center align-middle">
                <tr class="table-bordered">
                    <th class="table-success">Total Stock</th>
                    <th class="table-success">Total Sold</th>
                </tr>
                <tr>
                    <td class="fw-bold">{{ $books->total_stock }}</td>
                    <td class="fw-bold">{{ $books->total_sold }}</td>
                </tr>
        </table>
        <div class="text-end">
            <a href="{{ route('book.index') }}" class="btn btn-danger fw-bold">Back</a>
        </div>
    </section>
@endsection
