<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $category = Category::findOrFail($request->category_id);
        $request->validate([
            'category_id' => 'required',
            'amount' => 'required',
            'date' => 'required',
        ]);
        $data['user_id'] = auth()->id();
        $data['category_id'] = $request->category_id;
        $data['amount'] = $request->amount;
        $data['date'] = $request->date;
        $data['note'] = $request->note;
        $transaction = Transaction::create($data);
        return response()->json(['message' => 'Transaksi berhasil ditambahkan!', 'transaction' => $transaction->load('category')]);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return response()->json(['message' => 'Transaksi telah dihapus!']);
    }

    public function edit($id)
    {
        $transaction = Transaction::with('category')->findOrFail($id);
        return response()->json(['transaction' => $transaction, 'edit' => true]);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $category = Category::findOrFail($request->category_id);
        $request->validate([
            'category_id' => 'required',
            'amount' => 'required',
            'date' => 'required',
            'note' => 'required',
        ]);
        $transaction->update($request->only(['category_id', 'amount', 'date', 'note']));
        return response()->json(['message' => 'Transaksi berhasil diperbarui!', 'transaction' => $transaction->load('category')]);
    }

    public function downloadReport(Request $request)
    {
        $trx_range = $request->input('trx_range');
        $format = $request->input('format');

        $query = Transaction::with('category')->where('user_id', auth()->id());

        if ($trx_range === 'day') {
            $query->whereDate('date', Carbon::today());
        } elseif ($trx_range === 'week') {
            $query->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($trx_range === 'month') {
            $query->whereMonth('date', Carbon::now()->month)
                ->whereYear('date', Carbon::now()->year);
        }

        $transactions = $query->get();

        if ($format == 'pdf') {
            $pdf = PDF::loadView('transactions_pdf', compact('transactions'));
            return $pdf->download('laporan-transaksi.pdf');
        } elseif ($format == 'excel') {
            return Excel::download(new TransactionsExport($transactions), 'laporan-transaksi.xlsx');
        }

        return back()->with('error', 'Format tidak dikenal');
    }

    public function chartData(Request $request)
    {
        $year = $request->input('year', now()->year);

        $data = DB::table('transactions')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->whereYear('transactions.date', $year)
            ->selectRaw("DATE_FORMAT(transactions.date, '%Y-%m') as bulan")
            ->selectRaw("SUM(CASE WHEN categories.type = 'income' THEN transactions.amount ELSE 0 END) as pemasukan")
            ->selectRaw("SUM(CASE WHEN categories.type = 'expense' THEN transactions.amount ELSE 0 END) as pengeluaran")
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return response()->json($data);
    }
}
