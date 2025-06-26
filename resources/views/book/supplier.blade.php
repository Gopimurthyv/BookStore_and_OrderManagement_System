@extends('layouts.index')
@section('title','supplier details')
@section('heading', 'Supplier Details')

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
                        <th>Supplier Name</th>
                        <th>Email ID</th>
                        <th>Contact</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->email }}</td>
                        <td>{{ $supplier->contact }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-end">
            <a href="{{ route('book.index') }}" class="btn btn-danger fw-bold">Back</a>
        </div>
    </section>
@endsection
