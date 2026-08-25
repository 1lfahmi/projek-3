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

    public function dashboard()
    {
        // Mengambil jumlah data real-time dari database
        $now = Carbon::now();
        $startMonth = $now->copy()->startOfMonth();
        $previousMonth = $startMonth->copy()->subMonth();
        $totalMobil = Mobil::where('status', '!=', 'sold')->count();
        $totalPesanan = Pembelian::count(); 
        $totalUser = User::count();
        $visitorThisMonth = VisitorLog::whereBetween('visited_on', [$startMonth->toDateString(), $now->toDateString()])->count();
        $visitorPreviousMonth = VisitorLog::whereBetween('visited_on', [$previousMonth->toDateString(), $startMonth->copy()->subDay()->toDateString()])->count();
        $purchaseThisMonth = Pembelian::whereBetween('created_at', [$startMonth, $now])->count();
        $purchasePreviousMonth = Pembelian::whereBetween('created_at', [$previousMonth, $startMonth->copy()->subSecond()])->count();

        $months = collect(range(11, 0))->map(function ($monthsAgo) use ($now) {
            $date = $now->copy()->subMonths($monthsAgo);
            return ['label' => $date->format('M Y'), 'start' => $date->copy()->startOfMonth(), 'end' => $date->copy()->endOfMonth()];
        });
        $purchaseChart = $months->map(fn ($month) => Pembelian::whereBetween('created_at', [$month['start'], $month['end']])->count())->values();
        $visitorChart = $months->map(fn ($month) => VisitorLog::whereBetween('visited_on', [$month['start']->toDateString(), $month['end']->toDateString()])->count())->values();
        $chartLabels = $months->pluck('label')->values();
        $years = collect(range(5, 0))->map(fn ($yearsAgo) => $now->copy()->subYears($yearsAgo)->year);
        $yearlyPurchaseChart = $years->map(fn ($year) => Pembelian::whereYear('created_at', $year)->count())->values();
        $yearlyVisitorChart = $years->map(fn ($year) => VisitorLog::whereYear('visited_on', $year)->count())->values();

        // Mengirimkan data ke view admin.dashboard
        return view('admin.dashboard', compact('totalMobil', 'totalPesanan', 'totalUser', 'visitorThisMonth', 'visitorPreviousMonth', 'purchaseThisMonth', 'purchasePreviousMonth', 'chartLabels', 'purchaseChart', 'visitorChart', 'years', 'yearlyPurchaseChart', 'yearlyVisitorChart'));
    }
}