<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{   
    public function index()
    {
        $sales = Sale::with('items')->latest()->paginate(10);
        
        // Summary statistics
        $totalSales = Sale::where('payment_status', 'paid')->sum('total_amount');
        $totalTransactions = Sale::count();
        $todaySales = Sale::whereDate('transaction_date', today())
                         ->where('payment_status', 'paid')
                         ->sum('total_amount');
        
        return view('sales.index', compact('sales', 'totalSales', 'totalTransactions', 'todaySales'));
    }

    public function create()
    {
        $products = Product::where('availability', 1)->get();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'customer_name' => 'nullable|string|max:100',
            'customer_contact' => 'nullable|string|max:100',
            'payment_method' => 'required|in:cash,transfer,qris,debit_card,credit_card',
            'payment_status' => 'required|in:paid,pending',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Create sale
            $sale = Sale::create([
                'transaction_number' => Sale::generateTransactionNumber(),
                'transaction_date' => $request->transaction_date,
                'customer_name' => $request->customer_name,
                'customer_contact' => $request->customer_contact,
                'total_amount' => 0, // Will be calculated from items
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
                'notes' => $request->notes,
            ]);

            // Create sale items and calculate total
            $totalAmount = 0;
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                $unitPrice = $item['unit_price'] ?? $product->price;
                $quantity = $item['quantity'];
                $subtotal = $unitPrice * $quantity;
                
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);
                
                $totalAmount += $subtotal;
            }

            // Update sale total
            $sale->update(['total_amount' => $totalAmount]);

            DB::commit();

            return redirect()->route('sales.index')
                           ->with('success', 'Transaksi berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Sale $sale)
    {
        $sale->load('items.product');
        return view('sales.show', compact('sale'));
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')
                       ->with('success', 'Transaksi berhasil dihapus.');
    }

public function report(Request $request)
{
    $query = Sale::with('items')
                ->where('payment_status', 'paid');

    // Filter by date range
    if ($request->has('start_date') && $request->has('end_date')) {
        $query->whereBetween('transaction_date', [
            $request->start_date,
            $request->end_date
        ]);
    } else {
        // Default to current month
        $query->whereMonth('transaction_date', now()->month);
    }

    // Filter by payment method
    if ($request->has('payment_method') && $request->payment_method) {
        $query->where('payment_method', $request->payment_method);
    }

    $sales = $query->latest()->paginate(20);

    // Summary statistics
    $totalRevenue = $query->sum('total_amount');
    $totalTransactions = $query->count();
    $averageTransaction = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

    // Monthly report data for chart
    $monthlyData = Sale::select(
            DB::raw('YEAR(transaction_date) as year'),
            DB::raw('MONTH(transaction_date) as month'),
            DB::raw('SUM(total_amount) as total'),
            DB::raw('COUNT(*) as transactions')
        )
        ->where('payment_status', 'paid')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->limit(12)
        ->get();

    // Top products
    $topProducts = SaleItem::select(
            'product_id',
            'product_name',
            DB::raw('SUM(quantity) as total_quantity'),
            DB::raw('SUM(subtotal) as total_revenue')
        )
        ->whereHas('sale', function($q) use ($request) {
            $q->where('payment_status', 'paid');
            if ($request->has('start_date') && $request->has('end_date')) {
                $q->whereBetween('transaction_date', [
                    $request->start_date,
                    $request->end_date
                ]);
            }
        })
        ->groupBy('product_id', 'product_name')
        ->orderBy('total_quantity', 'desc')
        ->limit(10)
        ->get();

    // Payment method distribution
    $paymentDistribution = Sale::select(
            'payment_method',
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(total_amount) as total')
        )
        ->where('payment_status', 'paid')
        ->where(function($q) use ($request) {
            if ($request->has('start_date') && $request->has('end_date')) {
                $q->whereBetween('transaction_date', [
                    $request->start_date,
                    $request->end_date
                ]);
            }
        })
        ->groupBy('payment_method')
        ->get();

        return view('sales.report', compact(
            'sales', 
            'monthlyData', 
            'totalRevenue',
            'totalTransactions',
            'averageTransaction',
            'topProducts',
            'paymentDistribution'
        ));
    }
}