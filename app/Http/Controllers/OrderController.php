<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Customer;
use App\Models\Order;
use App\Models\StockDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::with(['customer','items.book'])->latest()->paginate(10);
        return view('orders.index',compact('orders'));
    }

    public function create(){
        $customers = Customer::all();
        $books = Book::with('stocks')->get()->filter(function($book){
            return $book->stocks->sum('quantity') > 0;
        });

        return view('orders.create', compact('customers', 'books'));
    }

    public function store(Request $request){

        try{
            $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'book_id.*' => 'required|exists:books,id',
                'quantity.*' => 'required|integer|min:1'
            ]);

            DB::transaction(function () use ($request) {
                $total = 0;
                $order = Order::create([
                    'customer_id' => $request->customer_id,
                    'order_date' => now(),
                    'total_price' => 0,
                ]);

                foreach ($request->book_id as $index => $bookId) {
                    $quantity = $request->quantity[$index];
                    $book = Book::with('stocks')->findOrFail($bookId);

                    $availableStock = $book->stocks->sum('quantity');

                    if($quantity > $availableStock){
                        throw ValidationException::withMessages([
                            "quantity.$index"=>"Requested quantity exceeds available stock for book: {$book->title}"
                        ]);
                    }

                    $unitPrice = $book->price;
                    $total += $unitPrice * $quantity;

                    $order->items()->create([
                        'book_id' => $bookId,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice
                    ]);

                    $remainingQty = $quantity;

                    $stock = StockDetail::where('book_id', $bookId)->where('quantity', '>', 0)->get();
                    foreach ($stock as $stockRow) {
                        if ($remainingQty <= 0) break;

                        $deduct = min($stockRow->quantity, $remainingQty);
                        $stockRow->decrement('quantity', $deduct);
                        $remainingQty -= $deduct;
                    }
                }

                $order->update(['total_price' => $total]);
            });

            return redirect()->route('order.index')->with('success', 'Order placed successfully!');

        } catch(\Exception $e){
            return back()->with('error',$e->getMessage())->withInput();
        }
    }

}
