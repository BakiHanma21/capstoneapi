<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use App\Models\Booking;
use App\Models\SkilledWorker;
use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $transactions = [];

        if ($user->role == 'WORKER') {
            $transactions = Transaction::where('request_id', $user->id)->get();
        } elseif ($user->role == 'USER') {
            $transactions = Transaction::where('customer_id', $user->id)->get();
        }

        // Transform the transactions to return relative paths
        $transactions = $transactions->map(function ($transaction) {
            if ($transaction->qr_code_url && !str_starts_with($transaction->qr_code_url, 'http')) {
                // Just return the relative path
                $transaction->qr_code_url = $transaction->qr_code_url;
            }
            if ($transaction->receipt_url && !str_starts_with($transaction->receipt_url, 'http')) {
                // Just return the relative path
                $transaction->receipt_url = $transaction->receipt_url;
            }
            return $transaction;
        });

        return TransactionResource::collection($transactions);
    }

    public function uploadQrCode(Request $request, $transactionId)
    {
        $transaction = Transaction::find($transactionId);
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $request->validate([
            'qr_code' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('qr_code')) {
            $file = $request->file('qr_code');
            $destinationPath = public_path('qr_codes');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            
            // Store the relative path only
            $relativePath = 'qr_codes/' . $filename;
            $transaction->qr_code_url = $relativePath;
            $transaction->save();

            return response()->json([
                'message' => 'QR Code uploaded successfully',
                'qr_code_url' => $relativePath
            ], 200);
        }

        return response()->json(['message' => 'No QR code file provided'], 400);
    }

    public function uploadReceipt(Request $request, $transactionId)
    {
        $transaction = Transaction::find($transactionId);
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $destinationPath = public_path('receipts');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
            
            // Store the relative path only
            $relativePath = 'receipts/' . $filename;
            $transaction->receipt_url = $relativePath;
            $transaction->save();

            return response()->json([
                'message' => 'Receipt uploaded successfully',
                'receipt_url' => $relativePath
            ], 200);
        }

        return response()->json(['message' => 'No receipt file provided'], 400);
    }

    public function markAsPaidManually($transactionId)
    {
        $transaction = Transaction::where('transaction_id', $transactionId)->first();
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $skilledworker = SkilledWorker::where('user_id', $transaction->request_id)->first();
        $booking = Booking::where('worker_id', $skilledworker->id)
            ->where('customer_id', $transaction->customer_id)
            ->where('title', $transaction->title)
            ->where('description', $transaction->description);
            

        $transaction->payment_status = 'MANUALLY UPDATED';
        $transaction->payment_date = now();
        $transaction->save();

        // Return relative paths in the response
        if ($transaction->qr_code_url && !str_starts_with($transaction->qr_code_url, 'http')) {
            $transaction->qr_code_url = $transaction->qr_code_url;
        }
        if ($transaction->receipt_url && !str_starts_with($transaction->receipt_url, 'http')) {
            $transaction->receipt_url = $transaction->receipt_url;
        }

        return response()->json([
            'message' => 'Payment status updated manually',
            'transaction' => $transaction
        ], 200);
    }

    // Other methods remain unchanged
    public function store(TransactionRequest $request): Transaction
    {
        return Transaction::create($request->validated());
    }

    public function show(Transaction $transaction): Transaction
    {
        // Return relative paths
        if ($transaction->qr_code_url && !str_starts_with($transaction->qr_code_url, 'http')) {
            $transaction->qr_code_url = $transaction->qr_code_url;
        }
        if ($transaction->receipt_url && !str_starts_with($transaction->receipt_url, 'http')) {
            $transaction->receipt_url = $transaction->receipt_url;
        }
        return $transaction;
    }

    public function update(TransactionRequest $request, Transaction $transaction): Transaction
    {
        $transaction->update([
            'payment_status' => $request->input('payment_status', $transaction->payment_status),
        ]);
        return $transaction;
    }

    public function destroy(Transaction $transaction): Response
    {
        $transaction->delete();
        return response()->noContent();
    }

    public function submitReview(Request $request, $transactionId)
    {
        $transaction = Transaction::find($transactionId);
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $request->validate([
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $transaction->review = $request->review;
        $transaction->rating = $request->rating;
        $transaction->save();

        return response()->json(['message' => 'Review submitted successfully', 'transaction' => $transaction]);
    }

    public function submitReview2(Request $request, $transactionId)
    {
        $transaction = Transaction::find($transactionId);
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $request->validate([
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $transaction->review2 = $request->review;
        $transaction->rating2 = $request->rating;
        $transaction->save();

        return response()->json(['message' => 'Review submitted successfully', 'transaction' => $transaction]);
    }
}