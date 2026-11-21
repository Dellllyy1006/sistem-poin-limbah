<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\PointRedemption;
use App\Models\User;
use App\Services\PointCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RedemptionController extends Controller
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

        $redemptions = PointRedemption::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $totalPoints = $user->total_points;
        $maxRupiah = $this->pointService->convertPointsToRupiah($totalPoints);
        $rupiahBreakdown = $this->pointService->calculateRupiahBreakdown($totalPoints);

        return view('peserta.redemptions.index', compact('user', 'redemptions', 'totalPoints', 'maxRupiah', 'rupiahBreakdown'));
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'points_used' => ['required', 'integer', 'min:1', 'max:' . $user->total_points],
        ], [
            'points_used.required' => 'Jumlah poin yang ingin ditukarkan wajib diisi.',
            'points_used.integer' => 'Poin harus berupa angka bulat positif.',
            'points_used.min' => 'Jumlah penukaran minimal 1 poin.',
            'points_used.max' => 'Poin yang ditukarkan tidak boleh melebihi saldo total poin Anda saat ini (' . $user->total_points . ' poin).',
        ]);

        $pointsToRedeem = $validated['points_used'];

        // Strict business rule: Peserta tidak dapat menukarkan poin ke Rupiah melebihi total_points
        if ($pointsToRedeem > $user->total_points) {
            return back()->with('error', 'Saldo poin tidak mencukupi untuk melakukan penukaran ini.');
        }

        // Calculate Rupiah via Service Class (Greedy algorithm)
        $rupiahAmount = $this->pointService->convertPointsToRupiah($pointsToRedeem);

        DB::transaction(function () use ($user, $pointsToRedeem, $rupiahAmount) {
            // Deduct points immediately to avoid race conditions
            User::where('id', $user->id)->decrement('total_points', $pointsToRedeem);

            PointRedemption::create([
                'user_id' => $user->id,
                'points_used' => $pointsToRedeem,
                'rupiah_amount' => $rupiahAmount,
                'status' => 'pending',
            ]);
        });

        return redirect()->route('peserta.redemptions.index')
            ->with('success', 'Klaim penukaran ' . $pointsToRedeem . ' poin menjadi Rp ' . number_format($rupiahAmount, 0, ',', '.') . ' berhasil diajukan dan sedang diproses Admin.');
    }
}
