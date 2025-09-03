<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $month = now()->month;
        $year = now()->year;

        $transactions = Transaction::where('user_id', auth()->id())
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();

        $totalIncome = $transactions->where('category.type', 'income')->sum('amount');
        $totalExpense = $transactions->where('category.type', 'expense')->sum('amount');
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

        $groupedByDate = $transactions->where('category.type', 'expense')->groupBy('date');
        $mostFrequentExpenseDay = $groupedByDate
            ->sortByDesc(fn($group) => $group->count())
            ->keys()
            ->first();
        $mostFrequentExpenseCount = $groupedByDate[$mostFrequentExpenseDay]->count() ?? 0;

        $chartData = $transactions->groupBy(function ($trx) {
            return \Carbon\Carbon::parse($trx->date)->format('d M');
        });

        $summaryLabels = $chartData->keys();
        $summaryIncome = $chartData->map(fn($g) => $g->where('category.type', 'income')->sum('amount'))->values();
        $summaryExpense = $chartData->map(fn($g) => $g->where('category.type', 'expense')->sum('amount'))->values();

        return view('home', compact(
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
