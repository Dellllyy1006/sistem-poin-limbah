<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WasteTransaction;
use App\Models\WasteGrade;
use App\Models\User;
use App\Services\PointCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    protected PointCalculationService $pointService;

    public function __construct(PointCalculationService $pointService)
    {
        $this->pointService = $pointService;
    }

    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = WasteTransaction::with(['user', 'category', 'grade', 'verifier'])->latest();

        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $transactions = $query->paginate(10)->withQueryString();
        $grades = WasteGrade::orderBy('bonus_point', 'desc')->get();

        return view('admin.transactions.index', compact('transactions', 'status', 'grades'));
    }

    public function show(WasteTransaction $transaction)
    {
        $transaction->load(['user', 'category', 'grade', 'verifier']);
        $grades = WasteGrade::orderBy('bonus_point', 'desc')->get();

        // Calculate potential points for each grade using the Service Class
        $gradePreviews = [];
        foreach ($grades as $g) {
            $base = $this->pointService->calculateBasePoints($transaction->category, $transaction->quantity_or_weight);
            $bonus = $this->pointService->calculateBonusPoints($g);
            $total = $this->pointService->calculateTotalPoints($transaction->category, $transaction->quantity_or_weight, $g);

            $gradePreviews[$g->id] = [
                'base' => $base,
                'bonus' => $bonus,
                'total' => $total,
            ];
        }

        return view('admin.transactions.show', compact('transaction', 'grades', 'gradePreviews'));
    }

    public function approve(Request $request, WasteTransaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi ini sudah diverifikasi sebelumnya.');
        }

        $validated = $request->validate([
            'grade_id' => ['required', 'exists:waste_grades,id'],
            'notes' => ['nullable', 'string', 'max:500'],
        ], [
            'grade_id.required' => 'Pilih grade kelayakan untuk menyetujui transaksi ini.',
            'grade_id.exists' => 'Grade kelayakan tidak valid.',
        ]);

        $grade = WasteGrade::findOrFail($validated['grade_id']);
        $category = $transaction->category;

        // Calculate total points strictly through PointCalculationService
        $totalPoints = $this->pointService->calculateTotalPoints($category, $transaction->quantity_or_weight, $grade);

        DB::transaction(function () use ($transaction, $grade, $totalPoints, $validated) {
            $transaction->update([
                'grade_id' => $grade->id,
                'earned_points' => $totalPoints,
                'status' => 'approved',
                'verified_by' => Auth::id(),
                'notes' => $validated['notes'] ?? null,
            ]);

            // Add points to participant balance only after approval (Rules.md)
            User::where('id', $transaction->user_id)->increment('total_points', $totalPoints);
        });

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi #' . $transaction->id . ' berhasil disetujui dengan Grade ' . $grade->grade_code . ' (' . $totalPoints . ' Poin ditambahkan ke saldo peserta).');
    }

    public function reject(Request $request, WasteTransaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi ini sudah diproses sebelumnya.');
        }

        $validated = $request->validate([
            'notes' => ['required', 'string', 'max:500'],
        ], [
            'notes.required' => 'Alasan penolakan wajib dicantumkan.',
        ]);

        $transaction->update([
            'status' => 'rejected',
            'verified_by' => Auth::id(),
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi #' . $transaction->id . ' telah ditolak.');
    }
}
