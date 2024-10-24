<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
     public function createPayment(Request $request){
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
        ]);

        $payment = Payment::create([
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        return response()->json($payment, 201);
    }

    public function successPayment(Request $request, $id){
        $payment = Payment::find($id);

        if ($payment->status !== 'pending') {
            return response()->json(['message' => 'Payment already processed'], 400);
        }

        $payment->status = 'completed';
        $payment->save();

        return response()->json($payment, 200);
    }
    public function cancelPayment($id){
        $payment = Payment::find($id);

        if ($payment->status !== 'pending') {
            return response()->json(['message' => 'Payment cannot be cancelled'], 400);
        }

        $payment->status = 'cancelled';
        $payment->save();

        return response()->json(['message' => 'Payment cancelled successfully'], 200);
    }
}
