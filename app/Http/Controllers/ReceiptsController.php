<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\AppTransaction;

class ReceiptsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
       
        $user = Auth::user();
        
        $transactions = AppTransaction::where('status', 'success')
                    ->Where('user_id', $user->id)
                    ->get();
                    
        return view('receipts/index', compact('transactions'));
    }


    /**
     * Download specific receipt
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $transaction = AppTransaction::findOrFail($id);
    
        $pdf = \PDF::loadView('auth.receipt', compact('transaction'));

        return $pdf->download('receipt.pdf');
    }
}
