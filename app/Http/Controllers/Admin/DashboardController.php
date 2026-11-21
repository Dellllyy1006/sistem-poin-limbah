<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WasteTransaction;
use App\Models\PointRedemption;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPeserta = User::where('role', 'peserta')->count();
        $pendingTransactions = WasteTransaction::where('status', 'pending')->count();
        $approvedTransactions = WasteTransaction::where('status', 'approved')->count();
        $totalPointsDistributed = WasteTransaction::where('status', 'approved')->sum('earned_points');
        $totalRedeemedRupiah = PointRedemption::where('status', 'completed')->sum('rupiah_amount');
        $pendingRedemptions = PointRedemption::where('status', 'pending')->count();

        $recentPending = WasteTransaction::with(['user', 'category'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $recentTransactions = WasteTransaction::with(['user', 'category', 'grade'])
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'totalPeserta',
            'pendingTransactions',
            'approvedTransactions',
            'totalPointsDistributed',
            'totalRedeemedRupiah',
            'pendingRedemptions',
            'recentPending',
            'recentTransactions'
        ));
    }
}
