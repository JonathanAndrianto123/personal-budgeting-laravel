<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        //filter transactions
        $trx_type = $request->input('trx_type');
        $trx_category = $request->input('trx_category');
        $trx_range = $request->input('trx_range');
        $query = Transaction::query();
        if ($trx_type) {
            $query->whereHas('category', function ($q) use ($trx_type) {
                $q->where('type', $trx_type);
            });
        }

        if ($trx_category) {
            $query->where('category_id', $trx_category);
        }

        if ($trx_range === 'day') {
            $query->whereDate('date', Carbon::today());
        } elseif ($trx_range === 'week') {
            $query->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($trx_range === 'month') {
            $query->whereMonth('date', Carbon::now()->month)
                ->whereYear('date', Carbon::now()->year);
        } elseif ($trx_range === 'year') {
            $query->whereYear('date', Carbon::now()->year);
        }

        $transactions = $query->with('category')->where('user_id', auth()->id())->orderBy('date', 'desc')->paginate(10);
        $categories = Category::where('user_id', auth()->id())->orderBy('type')->get();

        //chart
        $saldo = DB::table('transactions')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->selectRaw("
            SUM(CASE WHEN categories.type = 'income' THEN transactions.amount ELSE 0 END) -
            SUM(CASE WHEN categories.type = 'expense' THEN transactions.amount ELSE 0 END)
            as saldo")
            ->value('saldo');

        $years = DB::table('transactions')
            ->selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // dashboard
        $month = now()->month;
        $monthName = \Carbon\Carbon::create()->month($month)->locale('id')->translatedFormat('F');
        $year = now()->year;

        $dashboard_trx = Transaction::where('user_id', auth()->id())
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();

        $totalIncome = $dashboard_trx->where('category.type', 'income')->sum('amount');
        $totalExpense = $dashboard_trx->where('category.type', 'expense')->sum('amount');
        $totalBalance = $totalIncome - $totalExpense;

        $categorySummaries = Category::where('user_id', auth()->id())
            ->with([
                'transactions' => function ($q) use ($month, $year) {
                    $q->whereMonth('date', $month)
                        ->whereYear('date', $year)
                        ->where('user_id', auth()->id());
                }
            ])->get()->map(function ($cat) {
                $cat->total = $cat->transactions->sum('amount');
                return $cat;
            });

        $mostSpentCategory = $categorySummaries->where('type', 'expense')->sortByDesc('total')->first();

        $groupedByDate = $dashboard_trx->where('category.type', 'expense')->groupBy('date');
        if ($groupedByDate->isNotEmpty()) {
            $mostFrequentExpenseDay = $groupedByDate
                ->sortByDesc(fn($group) => $group->count())
                ->keys()
                ->first();

            $mostFrequentExpenseCount = $groupedByDate[$mostFrequentExpenseDay]->count();
        } else {
            $mostFrequentExpenseDay = null;
            $mostFrequentExpenseCount = 0;
        }


        $chartData = $dashboard_trx->groupBy(function ($trx) {
            return \Carbon\Carbon::parse($trx->date)->format('d M');
        });

        $summaryLabels = $chartData->keys();
        $summaryIncome = $chartData->map(fn($g) => $g->where('category.type', 'income')->sum('amount'))->values();
        $summaryExpense = $chartData->map(fn($g) => $g->where('category.type', 'expense')->sum('amount'))->values();

        return view('home', compact(
            'categories',
            'transactions',
            'trx_type',
            'trx_range',
            'trx_category',
            'saldo',
            'monthName',
            'year',
            'years',
            'totalBalance',
            'categorySummaries',
            'mostSpentCategory',
            'mostFrequentExpenseDay',
            'mostFrequentExpenseCount',
            'summaryLabels',
            'summaryIncome',
            'summaryExpense'
        ));
    }
}
