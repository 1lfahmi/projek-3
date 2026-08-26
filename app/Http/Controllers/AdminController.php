<?php

namespace App\Http\Controllers;

use App\Models\Mobil;      // Pastikan Model Mobil ada
use App\Models\Pembelian;  // Pastikan Model Pembelian ada
use App\Models\User;       // Pastikan Model User ada
use App\Models\VisitorLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index() {
        $mobils = Mobil::all();
        return view('admin.mobil.index', compact('mobils'));
    }

    public function dashboard(Request $request)
    {
        $now = Carbon::now();
        $period = $request->input('period', 'monthly');
        $selectedYear = (int) $request->input('year', $now->year);
        $selectedMonth = (int) $request->input('month', $now->month);

        $totalMobil = Mobil::where('status', '!=', 'sold')->count();
        $totalPesanan = Pembelian::count();
        $totalUser = User::count();

        $availableYears = collect()
            ->merge(VisitorLog::selectRaw('YEAR(visited_on) as year')->pluck('year'))
            ->merge(Pembelian::selectRaw('YEAR(created_at) as year')->pluck('year'))
            ->merge([$now->year])
            ->map(fn ($year) => (int) $year)
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $years = $availableYears->isNotEmpty() ? $availableYears : collect([$now->year]);
        if (! $years->contains($selectedYear)) {
            $selectedYear = $years->last();
        }

        $selectedMonth = in_array($selectedMonth, range(1, 12), true) ? $selectedMonth : $now->month;

        $months = collect(range(1, 12))->map(function ($month) use ($selectedYear) {
            return [
                'value' => $month,
                'label' => Carbon::create($selectedYear, $month, 1)->locale('id')->translatedFormat('F'),
            ];
        });

        if ($period === 'yearly') {
            $chartLabels = $years->map(fn ($year) => (string) $year)->values();
            $purchaseChart = $years->map(fn ($year) => Pembelian::whereYear('created_at', $year)->count())->values();
            $visitorChart = $years->map(fn ($year) => VisitorLog::whereYear('visited_on', $year)->count())->values();

            $selectedPeriodStart = Carbon::create($selectedYear, 1, 1, 0, 0, 0);
            $selectedPeriodEnd = Carbon::create($selectedYear, 12, 31, 23, 59, 59);
            $previousPeriodStart = $selectedPeriodStart->copy()->subYear();
            $previousPeriodEnd = $selectedPeriodEnd->copy()->subYear();
        } else {
            $chartLabels = $months->map(fn ($month) => $month['label'])->values();
            $purchaseChart = $months->map(function ($month) use ($selectedYear) {
                $start = Carbon::create($selectedYear, $month['value'], 1, 0, 0, 0);
                $end = $start->copy()->endOfMonth();

                return Pembelian::whereBetween('created_at', [$start, $end])->count();
            })->values();
            $visitorChart = $months->map(function ($month) use ($selectedYear) {
                $start = Carbon::create($selectedYear, $month['value'], 1, 0, 0, 0);
                $end = $start->copy()->endOfMonth();

                return VisitorLog::whereBetween('visited_on', [$start->toDateString(), $end->toDateString()])->count();
            })->values();

            $selectedPeriodStart = Carbon::create($selectedYear, $selectedMonth, 1, 0, 0, 0);
            $selectedPeriodEnd = $selectedPeriodStart->copy()->endOfMonth();
            $previousPeriodStart = $selectedPeriodStart->copy()->subMonth()->startOfMonth();
            $previousPeriodEnd = $selectedPeriodStart->copy()->subMonth()->endOfMonth();
        }

        $visitorThisMonth = VisitorLog::whereBetween('visited_on', [$selectedPeriodStart->toDateString(), $selectedPeriodEnd->toDateString()])->count();
        $visitorPreviousMonth = VisitorLog::whereBetween('visited_on', [$previousPeriodStart->toDateString(), $previousPeriodEnd->toDateString()])->count();
        $purchaseThisMonth = Pembelian::whereBetween('created_at', [$selectedPeriodStart, $selectedPeriodEnd])->count();
        $purchasePreviousMonth = Pembelian::whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])->count();

        $periodLabel = $period === 'yearly'
            ? 'Tahun ' . $selectedYear
            : Carbon::create($selectedYear, $selectedMonth, 1)->locale('id')->translatedFormat('F Y');

        return view('admin.dashboard', compact(
            'totalMobil',
            'totalPesanan',
            'totalUser',
            'visitorThisMonth',
            'visitorPreviousMonth',
            'purchaseThisMonth',
            'purchasePreviousMonth',
            'chartLabels',
            'purchaseChart',
            'visitorChart',
            'years',
            'months',
            'selectedYear',
            'selectedMonth',
            'period',
            'periodLabel'
        ));
    }
}