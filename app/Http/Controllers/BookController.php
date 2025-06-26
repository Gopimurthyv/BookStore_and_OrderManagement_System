<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\Category;
use App\Models\Country;
use App\Models\State;
use App\Models\StockDetail;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    public function index(Request $request){
        $categoryFilter = $request->get('category');
        $stockFilter = $request->get('stock');

        $books = Book::with(['authors','stocks','supplier','orderItems'])
                ->when($categoryFilter,function($query,$categoryFilter){
                    return $query->whereJsonContains('category', $categoryFilter);
                })
                ->whereNull('deleted_at')
                ->get()
                ->map(function ($book) {
                    $book->total_stock = $book->stocks->sum('quantity');
                    $book->total_sold = $book->orderItems->sum('quantity');
                    return $book;
                });

        if ($stockFilter === 'available') {
            $books = $books->filter(fn($book) => $book->total_stock > 0);
        } elseif ($stockFilter === 'out') {
            $books = $books->filter(fn($book) => $book->total_stock == 0);
        }

        $categories = Category::pluck('name');

        return view('book.index',compact('books','categories','categoryFilter','stockFilter'));
    }

    public function create(){
        $categories = Category::all();
        $suppliers = Supplier::all();
        $countries = Country::all();

        return view('book.create',compact('categories','suppliers','countries'));
    }

    public function store(Request $request){
        try{
            $request->validate([
                'title'=> 'required|string|regex:/^[A-Za-z\s]+$/|max:255',
                'isbn'=> 'required|digits:13|unique:books,isbn',
                'image'=> 'required|image|mimes:jpg,png|max:350',
                'price'=> 'required',
                'published_date'=> 'required|date',
                'language'=> 'required|in:English,Tamil,Hindi,French',
                'category'=> 'required|array|min:1',
                'country'=> 'required',
                'state'=> 'required',
                'supplier'=> 'required',
                'authors'=> 'required|array|min:1|max:3',
                'authors.*.name'=> 'required|string',
                'authors.*.email'=> 'required|email',
                'stocks'=> 'required|array|min:1|max:4',
                'stocks.*.location'=> 'required|string',
                'stocks.*.quantity'=> 'required|integer|min:1',
            ]);

            $bookId = rand(100000, 999999);
            while(Book::where('book_id',$bookId)->exists()){
                $bookId = rand(100000,999999);
            }

            if($request->hasFile('image')){
                $image = $request->file('image');
                $filename = time().'.'.$image->extension();
                $image->storeAs('images/', $filename,'public');
            }

            $book = Book::create([
                'book_id'=> $bookId,
                'title'=> $request->title,
                'isbn'=> $request->isbn,
                'image'=> $filename,
                'price'=> $request->price,
                'published_date'=> $request->published_date,
                'language'=> $request->language,
                'categories'=> json_encode($request->category),
                'country_id'=> $request->country,
                'state_id'=> $request->state,
                'supplier_id'=> $request->supplier,
            ]);

            foreach($request->authors as $author){
                BookAuthor::create([
                    'book_id'=> $book->id,
                    'author_name'=> $author['name'],
                    'author_email'=> $author['email'],
                ]);
            }

            foreach($request->stocks as $stock){
                StockDetail::create([
                    'book_id'=> $book->id,
                    'store_location'=> $stock['location'],
                    'quantity'=> $stock['quantity'],
                ]);
            }

            return redirect()->route('book.index')->with('success','Books Added Successfully');
        }catch(ValidationException $e){
            return back()->withErrors($e->validator)->withInput();
        } catch(\Exception $e){
            return back()->with('error',$e->getMessage())->withInput();
        }
    }

    public function show($id){
        $book = Book::with(['authors', 'supplier', 'stocks', 'orderItems'])->findOrFail($id);

        $totalStock = $book->stocks->sum('quantity');
        $totalSold = $book->orderItems->sum('quantity');

        return view('book.book-details', compact('book', 'totalStock', 'totalSold'));
    }

    public function edit($id){
        $book = Book::with('authors','supplier','stocks')->findOrFail($id);
        $countries = Country::all();
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('book.update',compact('book','countries','categories','suppliers'));
    }

    public function update(Request $request, $id){
        try{
            $request->validate([
                'title'=> 'required|string|regex:/^[A-Za-z\s]+$/',
                'isbn'=> 'required|digits:13',
                'image'=> 'nullable|image|mimes:jpg,png|max:350',
                'price'=> 'required',
                'published_date'=> 'nullable|date',
                'language'=> 'required|in:English,Tamil,Hindi,French',
                'category'=> 'required|array|min:1',
                'country'=> 'required',
                'state'=> 'required',
                'supplier'=> 'required',
                'authors'=> 'required|array|min:1|max:3',
                'authors.*.name'=> 'required|string',
                'authors.*.email'=> 'required|email',
                'stocks'=> 'required|array|min:1|max:4',
                'stocks.*.location'=> 'required|string',
                'stocks.*.quantity'=> 'required|integer|min:1',
            ]);

            $book = Book::findOrFail($id);

            if($request->hasFile('image')){
                $file = $request->file('image');
                $filename = time() .'.'. $file->extension();
                $file->storeAs('images/', $filename,'public');
                $book->image = $filename;
            }

            $book->update([
                'title'=> $request->title,
                'isbn'=>$request->isbn,
                'price'=> $request->price,
                'published_date'=> $request->published_date,
                'language'=> $request->language,
                'categories'=> json_encode($request->category),
                'country_id'=>$request->country,
                'state_id'=> $request->state,
                'supplier_id'=> $request->supplier,
                'image'=> $book->image,
            ]);

            BookAuthor::where('book_id', $book->id)->delete();
            foreach($request->authors as $author){
                BookAuthor::create([
                    'book_id'=> $book->id,
                    'author_name'=> $author['name'],
                    'author_email'=> $author['email'],
                ]);
            }

            StockDetail::where('book_id',$book->id)->delete();
            foreach($request->stocks as $stock){
                StockDetail::create([
                    'book_id'=> $book->id,
                    'store_location'=> $stock['location'],
                    'quantity'=> $stock['quantity'],
                ]);
            }

            return redirect()->route('book.index');
        }catch(ValidationException $e){
            return back()->withErrors($e->validator)->withInput();
        }catch(\Exception $e){
            return back()->with('error',$e->getMessage())->withInput();
        }
    }

    public function destroy($id){
        $book = Book::with(['stocks','authors'])->findOrFail($id);
        $book->delete();
        return redirect()->route('book.index');
    }

    public function stockDetails($id){
        $books = Book::with('stocks', 'orderItems')->findOrFail($id);

        $books->total_stock = $books->stocks->sum('quantity');
        $books->total_sold = $books->orderItems->sum('quantity');
        $stocks = $books->stocks;

        return view('book.stockDetails',compact('stocks','books'));
    }

    public function supplier($id){
        $books = Book::with('supplier')->findOrFail($id);
        $supplier = $books->supplier;

        return view('book.supplier',compact('supplier','books'));
    }

    public function supplierFilter(Request $request){
        $supplier = $request->get('supplier');

        $books = Book::with(['authors', 'stocks', 'supplier'])
                    ->when($supplier, function ($query) use ($supplier) {
                        return $query->whereHas('supplier', function ($q) use ($supplier) {
                            $q->where('name', $supplier);
                        });
                    })
                    ->whereNull('deleted_at')
                    ->get()
                    ->map(function ($book) {
                        $book->total_stock = $book->stocks->sum('quantity');
                        $book->total_sold = $book->orderItems->sum('quantity');
                        return $book;
                    });

        return view('book.book-list', compact('books'))->render();
    }


    public function getStates($countryId){
        $states = State::where('country_id',$countryId)->get();
        return response()->json($states);
    }

    public function bookCategory(Request $request){
        $query = Book::with(['supplier','stocks','supplier','orderItems'])->whereNull('deleted_at');

        if($request->filled('category')){
            $query->where('categories', 'like', '%'.$request->category.'%');
        }

        $books = $query->get()->map(function ($book) {
                    $book->total_stock = $book->stocks->sum('quantity');
                    $book->total_sold = $book->orderItems->sum('quantity');
                    return $book;
                });

        return view('book.book-list', compact('books'))->render();
    }

    public function bookSearch(Request $request){
        $query = $request->search;
        $books = Book::where('title','like',"%{$query}%")
                    ->get();

        return view('book.book-searchTable', compact('books'))->render();
    }

    public function trash(){
        $trashedBooks = Book::onlyTrashed()->with(['authors', 'stocks', 'orderItems'])
                        ->get()
                        ->map(function ($book) {
                            $book->total_stock = $book->stocks->sum('quantity');
                            $book->total_sold = $book->orderItems->sum('quantity');
                            return $book;
                        });

        return view('book.trash', compact('trashedBooks'));
    }

    public function restore($id){
        $book = Book::onlyTrashed()->findOrFail($id);
        $book->restore();
        return redirect()->route('book.trash')->with('success','Books Restored Successfully!..');
    }

    public function forceDelete($id){
        $book = Book::onlyTrashed()->findOrFail($id);
        $book->forceDelete();
        return redirect()->route('book.trash')->with('success','Books Deleted Permanently..');
    }
}
