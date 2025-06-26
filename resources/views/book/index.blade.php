@extends('layouts.index')
@section('title','index')
@section('heading','Book List')

@section('header')
    <section>
        <div class="row d-flex-column  align-items-center">
            <div class="col-auto">
                <select name="category" id="categoryFilter" class="form-select">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" {{ $categoryFilter == $category ? 'selected' :'' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <select name="supplier" id="supplier" class="form-select">
                    <option value="">Supplier</option>
                    <option value="bookwala">BookWala</option>
                    <option value="usedbooks">UsedBooks</option>
                    <option value="abcbooks">AbcBooks</option>
                    <option value="modernbooks">ModernBooks</option>
                    <option value="jeyagaanthan">Jeyagaanthan</option>
                    <option value="bharathi">Bharathi</option>
                </select>
            </div>
            <div class="col-auto">
                    <div class="btn-group " role="group">
                        <a href="{{ route('book.index', ['stock' => 'available']) }}" class="btn btn-outline-success {{ $stockFilter == 'available' ? 'active' : '' }}">Available Stock</a>
                        <a href="{{ route('book.index') }}" class="btn btn-outline-primary {{ !$stockFilter ? 'active' : '' }}">All</a>
                        <a href="{{ route('book.index', ['stock' => 'out']) }}" class="btn btn-outline-danger {{ $stockFilter == 'out' ? 'active' : '' }}">Out of Stock</a>
                    </div>
            </div>
            <div class="col text-end">
                <a href="{{ route('book.create') }}" class="btn btn-success fw-bold">Add Book <img src="{{ asset('plus.png') }}" width="20" height="20"></a>
            </div>
        </div>
    </section>
@endsection

@section('table')
    <table class="table table-bordered align-middle text-center shadow-lg">
        <thead class="table-primary ">
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Price</th>
                <th>Language</th>
                <th>Categories</th>
                <th>Supplier</th>
                <th>Stock Details</th>
                <th>Total Stock</th>
                <th>Total Sold</th>
                <th>Author Names</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="books-table">
                @forelse ($books as $book)
                    <tr>
                        <td><img src="{{ asset('storage/images/'.$book->image) }}" width="50" height="50"></td>
                        <td>
                            <a href="{{ route('book.details',$book->id) }}" class="text-decoration-none">{{ $book->title }}</a>
                        </td>
                        <td>₹{{ $book->price }}</td>
                        <td>{{ $book->language }}</td>
                        <td>
                            @foreach (json_decode($book->categories) as $category)
                                <span class="badge bg-primary">{{ $category }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('book.supplier',$book->id) }}" class="text-decoration-none">{{ $book->supplier->name ?? 'N/A' }}</a>
                        </td>
                        <td>
                            <a href="{{ route('book.stock.detail',$book->id) }}" class="link-primary link-opacity-50-hover">View</a>
                        </td>
                        <td class="{{ $book->total_stock > 0 ? 'text-success' : 'text-danger' }}">{{ $book->total_stock > 0 ? $book->total_stock : 'Out of Stock'}}</td>
                        <td>{{ $book->total_sold }}</td>
                        <td>
                            {{ $book->authors->pluck('author_name')->implode(', ') }}
                        </td>
                        <td >
                            <div class="d-flex gap-2">
                                <a href="{{ route('book.edit',$book->id) }}" class="btn btn-sm "><img src="{{ asset('document-edit_114472.ico') }}" width="35"></a>
                                <a href="{{ route('book.destroy',$book->id) }}" class="btn  btn-sm" onclick="return confirm('Are you sure you want to delete?');"><img src="{{ asset('delete.png') }}" width="35"></a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td class="text-center" colspan="10">No Books Found.</td></tr>
                @endforelse
            </tbody>
        </table>
@endsection
