<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\WasteTransaction;
use App\Models\PointRedemption;
use App\Services\PointCalculationService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected PointCalculationService $pointService;

    public function __construct(PointCalculationService $pointService)
    {
        $this->pointService = $pointService;
    }

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $totalPoints = $user->total_points;
        $rupiahEquivalent = $this->pointService->convertPointsToRupiah($totalPoints);
        $rupiahBreakdown = $this->pointService->calculateRupiahBreakdown($totalPoints);

        $totalTransactions = WasteTransaction::where('user_id', $user->id)->count();
        $pendingTransactions = WasteTransaction::where('user_id', $user->id)->where('status', 'pending')->count();
        $approvedTransactions = WasteTransaction::where('user_id', $user->id)->where('status', 'approved')->count();
        $totalClaimedRupiah = PointRedemption::where('user_id', $user->id)->where('status', 'completed')->sum('rupiah_amount');

        $recentTransactions = WasteTransaction::with(['category', 'grade'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $recentRedemptions = PointRedemption::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('peserta.dashboard', compact(
            'user',
            'totalPoints',
            'rupiahEquivalent',
            'rupiahBreakdown',
            'totalTransactions',
            'pendingTransactions',
            'approvedTransactions',
            'totalClaimedRupiah',
            'recentTransactions',
            'recentRedemptions'
        ));
    }
}
