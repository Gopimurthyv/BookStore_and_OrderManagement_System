@extends('layouts.form')
@section('title','create')
@section('heading','Add a Book to the List')

{{-- @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif --}}

@section('content')
    <form action="{{ route('book.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <span class="text-danger">*</span>
            <label class="form-label fw-bold">Title</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <span class="text-danger">*</span>
                <label class="form-label fw-bold">ISBN</label>
                <input type="text" name="isbn" class="form-control @error('isbn') is-invalid @enderror" value="{{ old('isbn') }}" maxlength="13">
                @error('isbn')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-6">
                <span class="text-danger">*</span>
                <label class="form-label fw-bold">Image</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" >
                @error('image')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <span class="text-danger">*</span>
                <label class="form-label fw-bold">Price</label>
                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" step="1" min="0">
                @error('price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-6">
                <span class="text-danger">*</span>
                <label class="form-label fw-bold">Published Date</label>
                <input type="date" name="published_date" class="form-control @error('published_date') is-invalid @enderror" value="{{ old('published_date') }}">
                @error('published_date')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <span class="text-danger">*</span>
            <label class="form-label fw-bold">Language</label>
            <select name="language" class="form-select @error('language') is-invalid @enderror">
                <option value="">--select language--</option>
                @foreach (['English','Tamil','Hindi','French'] as $language)
                    <option value="{{ $language }}" {{ old('language') == $language ? "selected" : ""}}>{{ $language }}</option>
                @endforeach
            </select>
            @error('language')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <span class="text-danger">*</span>
            <label class="form-label fw-bold">Categories</label>
            @foreach ($categories as $category)
                <div class="form-check form-check-inline">
                    <input type="checkbox" name="category[]" class="form-check-input" value="{{ $category->name }}" {{ in_array($category->name, old('category',[])) ? "checked" : "" }}>
                    <label class="form-check-label">{{ $category->name }}</label>
                </div>
            @endforeach
            @error('category')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <span class="text-danger">*</span>
                <label class="form-label fw-bold">Country</label>
                <select name="country" id="country" class="form-select @error('country') is-invalid @enderror">
                    <option value="">--Select Country--</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}" {{ old('country') == $country->id ? "selected" :"" }}>{{ $country->name }}</option>
                    @endforeach
                </select>
                @error('country')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-6">
                <span class="text-danger">*</span>
                <label class="form-label fw-bold">State</label>
                <select name="state" id="state" class="form-select" disabled>
                    <option value="">--Select State--</option>
                </select>
                @error('state')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <hr>
        <div class="mb-3">
            <span class="text-danger">*</span>
            <label class="form-label fw-bold">Author</label>
            <div class="card p-3" id="authors">
                    @php
                        $oldAuthors = old('authors',[['name'=>'','email'=>'']]);
                        $authorCount = count($oldAuthors);
                    @endphp

                    @foreach ($oldAuthors as $index=>$author)
                        <div class="row author-row mb-3">
                            <div class="col">
                                <input type="text" name="authors[{{ $index }}][name]" class="form-control @error("authors.$index.name") is-invalid @enderror" placeholder="Name" value="{{ old("authors.$index.name",$author['name'] ?? "") }}" >
                            </div>
                            <div class="col">
                                <input type="email" name="authors[{{ $index }}][email]" class="form-control @error("authors.$index.email") is-invalid @enderror" value="{{ old("authors.$index.email",$author['email'] ?? "") }}" placeholder="Email" >
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger btn-sm removeAuthor ">Remove</button>
                            </div>
                        </div>
                    @endforeach
            </div>
            <div class="text-end mt-2"><button class="btn btn-secondary btn-sm" id="addAuthor" type="button">Add More</button></div>
        </div>
        <hr>
        <div class="mb-3">
            <span class="text-danger">*</span>
            <label class="form-label fw-bold">Supplier</label>
            <select name="supplier" class="form-select @error('supplier') is-invalid @enderror">
                <option value="">--Select Supplier--</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('supplier') == $supplier->id ? "selected" : ""}}>{{ $supplier->name }}</option>
                @endforeach
            </select>
            @error('supplier')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <hr>
        <div class="mb-3">
            <label class="form-label fw-bold">Stock Details</label>
            <table class="table table-bordered" id="stock_detail">
                <thead class="table-dark">
                    <tr>
                        <th>Store Location</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $oldStocks = old('stocks',[['location'=>'','quantity'=>'']]);
                        $stocksCount = count($oldStocks);
                    @endphp
                    @foreach ($oldStocks as $index=>$stock)
                        <tr>
                            <td>
                                <input type="text" name="stocks[{{ $index }}][location]" class="form-control @error("stocks.$index.location") is-invalid @enderror" value="{{ old("stocks.$index.location", $stock['location']) }}">
                            </td>
                            <td>
                                <input type="number" class="form-control @error("stocks.$index.quantity") is-invalid @enderror" name="stocks[{{ $index }}][quantity]" value="{{ old("stocks.$index.quantity",$stock['quantity']) }}">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm removeStock ">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-end">
                <button class="btn btn-secondary btn-sm" id="addStock" type="button">Add More</button>
            </div>
        </div>
        <div>
            <button class="btn btn-success" type="submit">ADD BOOKS</button>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        let authorCount = {{ $authorCount }};
        let stockCount = {{ $stocksCount }};

        $('#addAuthor').click(function(){
            if(authorCount < 3){
                $('#authors').append(`
                    <div class="row author-row mb-3">
                        <div class="col">
                            <input type="text" name="authors[${authorCount}][name]" class="form-control @error("authors.$index.name") is-invalid @enderror" placeholder="Name" value="{{ old("authors.$index.name",$author['name'] ?? "") }}">
                        </div>
                        <div class="col">
                            <input type="email" name="authors[${authorCount}][email]" class="form-control @error("authors.$index.email") is-invalid @enderror" value="{{ old("authors.$index.email",$author['email'] ?? "") }}" placeholder="Email">
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger btn-sm removeAuthor ">Remove</button>
                        </div>
                    </div>
                `);
                $('.removeAuthor').removeClass('d-none');
                authorCount++;
            } else{
                alert('Maximum of 3 Authors Reached .');
            }
        });

        $('#authors').on('click','.removeAuthor',function(){
            if ($('#authors .author-row').length > 1) {
                $(this).closest('.author-row').remove();
                authorCount--;
            } else {
                alert('Atleast 1 Author is Required.');
            }
        });

        $('#addStock').click(function(){
            if(stockCount < 4){
                $('#stock_detail tbody').append(`
                    <tr>
                        <td><input type="text" name="stocks[${stockCount}][location]" class="form-control"></td>
                        <td><input type="number" name="stocks[${stockCount}][quantity]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeStock">Remove</button></td>
                    </tr>
                `);
                $('.removeStock').removeClass('d-none');
                stockCount++;
            } else {
                alert("Maximum 4 Stock Entries Allowed");
            }
        });

        $(document).on('click','.removeStock',function(){
            if ($('#stock_detail tbody tr').length > 1) {
                $(this).closest('tr').remove();
                stockCount--;
            } else{
                alert('Atleast 1 Stock is Required..');
            }
        });

        $(document).ready(function(){
            $('#country').on('change',function(){
                let country = $(this).val();
                let state = $('#state');

                state.prop('disabled', true).html("<option value=''>--Loading--</option>");

                if(country){
                    $.ajax({
                        url: '/get-states/' + country,
                        type: 'GET',
                        success: function(states){
                            let options = "<option value=''>--SELECT STATE--</option>";
                            let oldState = "{{ old('state') }}";
                            $.each(states, function(index, stateObj){
                                let selected = (oldState == stateObj.id) ? "selected" : "";
                                options += "<option value='" + stateObj.id + "'"+selected+">" + stateObj.name + "</option>";
                            });
                            state.prop('disabled', false).html(options);
                        },
                        error: function(){
                            state.html("<option value=''>--ERROR LOADING STATES--</option>");
                        }
                    });
                } else {
                    state.prop('disabled', true).html('<option value="">--SELECT STATE--</option>');
                }
            });

            let oldCountry = "{{ old('country') }}";
            if(oldCountry) {
                $('#country').val(oldCountry).trigger('change');
            }
        });
    </script>
@endpush
