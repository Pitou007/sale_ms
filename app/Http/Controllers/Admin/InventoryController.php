<?php
namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index(Request $request){
        $type = $request->query('type');
        $from = $request->query('from');
        $to = $request->query('to');


        $tx = StockTransaction::query()
        ->when($type, fn($q)=>$q->where('type',$type))
        ->when($from, fn($q)=>$q->whereDate('date','>=',$from))
        ->when($to, fn($q)=>$q->whereDate('date','<=',$to))
        ->with(['product','user','supplier'])
        ->latest()
        ->paginate(20);


    return view('admin.inventory.transactions', compact('tx','type','from','to'));
    }

    public function stockIn(Request $request){
        $data = $request->validate([
            'product_id' => ['required','exists:products,id'],
            'supplier_id' => ['nullable','exists:suppliers,id'],
            'qty' => ['required','integer','min:1'],
            'note' => ['nullable','string'],
        ]);


        return DB::transaction(function() use ($request, $data){
            $p = Product::lockForUpdate()->findOrFail($data['product_id']);
            $p->increment('qty', $data['qty']);


            StockTransaction::create([
                'product_id' => $p->id,
                'user_id' => $request->user()->id,
                'supplier_id' => $data['supplier_id'] ?? null,
                'type' => 'in',
                'qty' => $data['qty'],
                'date' => now()->toDateString(),
                'note' => $data['note'] ?? null,
            ]);


            return back()->with('ok','Stock In recorded');
        });
    }

    public function stockOut(Request $request){
        $data = $request->validate([
            'product_id' => ['required','exists:products,id'],
            'qty' => ['required','integer','min:1'],
            'note' => ['nullable','string'],
        ]);


        return DB::transaction(function() use ($request, $data){
            $p = Product::lockForUpdate()->findOrFail($data['product_id']);
            if($p->qty < $data['qty']) abort(422, 'Not enough stock');
            $p->decrement('qty', $data['qty']);


            StockTransaction::create([
                'product_id' => $p->id,
                'user_id' => $request->user()->id,
                'supplier_id' => null,
                'type' => 'out',
                'qty' => $data['qty'],
                'date' => now()->toDateString(),
                'note' => $data['note'] ?? null,
            ]);


            return back()->with('ok','Stock Out recorded');
        });
    }
    public function broken(Request $request){
        $data = $request->validate([
            'product_id' => ['required','exists:products,id'],
            'qty' => ['required','integer','min:1'],
            'note' => ['nullable','string'],
        ]);


        return DB::transaction(function() use ($request, $data){
            $p = Product::lockForUpdate()->findOrFail($data['product_id']);
            if($p->qty < $data['qty']) abort(422, 'Not enough stock');
            $p->decrement('qty', $data['qty']);


            StockTransaction::create([
                'product_id' => $p->id,
                'user_id' => $request->user()->id,
                'supplier_id' => null,
                'type' => 'broken',
                'qty' => $data['qty'],
                'date' => now()->toDateString(),
                'note' => $data['note'] ?? null,
            ]);


            return back()->with('ok','Broken recorded');
        });
    }

    public function transfer(Request $request){
        $data = $request->validate([
            'product_id' => ['required','exists:products,id'],
            'qty' => ['required','integer','min:1'],
            'note' => ['nullable','string'],
        ]);


        return DB::transaction(function() use ($request, $data){
            $p = Product::lockForUpdate()->findOrFail($data['product_id']);
            if($p->qty < $data['qty']) abort(422, 'Not enough stock');
            $p->decrement('qty', $data['qty']);


            StockTransaction::create([
                'product_id' => $p->id,
                'user_id' => $request->user()->id,
                'supplier_id' => null,
                'type' => 'transfer',
                'qty' => $data['qty'],
                'date' => now()->toDateString(),
                'note' => $data['note'] ?? null,
            ]);
            return back()->with('ok','Transfer recorded');
        });
    }
}
