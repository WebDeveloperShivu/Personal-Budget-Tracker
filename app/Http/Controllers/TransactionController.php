<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('status', 1)->get();
        $action = "{{route('transactions.create')}}";
        $heading = "Transactions";
        return view('transactions.index', compact('transactions','action','heading'));
    }

    public function create()
    {
       
            $heading = "Create New transactions";
            $btntext = "Create";
            $actionurl = route('transactions.store');
    
        return view('transactions.create',compact('heading','btntext','actionurl'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'type' => 'required',
        ]);
    
        
        // Create a new transaction record with validated data
        Transaction::create($validatedData);
    
        // Redirect to the transactions index with a success message
        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully');
    }
    

    public function edit($id)
    {
        $heading = "Update New transactions";
        $btntext = "Update";
        $actionurl = route('transactions.update');

        $transaction = Transaction::find($id);

        return view('transactions.create', compact('transaction','heading','btntext','actionurl'));
    }

   
    

        
    public function update(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'type' => 'required|string',
            'id' => 'required|integer|exists:transactions,id', // Validate ID
        ]);
    
        $id = $request->input('id'); // Use input method
    
        $transaction = Transaction::find($id);
    
        if (!$transaction) {
            return back()->with('error', 'Transaction not found');
        }
    
        $transaction->update([
            'description' => $request->input('description'),
            'amount' => $request->input('amount'),
            'date' => $request->input('date'),
            'type' => $request->input('type'),
        ]);
    
        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully');
    }
    
    public function disable( $id)
    {
      

            // Your deletion logic here
            $Transaction = Transaction::findOrFail($id);
                $Transaction->status = '0';
                $Transaction->save();
    
                if($Transaction){
                    return redirect()->route('transactions.index')->with('delete', 'Transaction Disable Successfully');
                }else{
                    return redirect()->route('transactions.index')->with('info', 'Internal Serve Error');
                }
            
        

       
    }

    
    

}
