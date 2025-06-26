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
