<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\WasteCategory;
use App\Models\WasteTransaction;
use App\Services\PointCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    protected PointCalculationService $pointService;

    public function __construct(PointCalculationService $pointService)
    {
        $this->pointService = $pointService;
    }

    public function index()
    {
        $user = Auth::user();
        $transactions = WasteTransaction::with(['category', 'grade'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('peserta.transactions.index', compact('transactions'));
    }

    public function create()
    {
        // Only Botol and Kaleng are permitted in the system per Rules.md
        $categories = WasteCategory::whereIn('name', ['Botol', 'Kaleng'])->get();

        return view('peserta.transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:waste_categories,id'],
            'quantity_or_weight' => ['required', 'integer', 'min:1'],
        ], [
            'category_id.required' => 'Silakan pilih kategori limbah (Botol atau Kaleng).',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'quantity_or_weight.required' => 'Jumlah atau berat limbah wajib diisi.',
            'quantity_or_weight.integer' => 'Nilai harus berupa angka bulat positif.',
            'quantity_or_weight.min' => 'Nilai minimal adalah 1.',
        ]);

        $category = WasteCategory::findOrFail($validated['category_id']);

        // Strict validation according to Rules.md
        if (!in_array($category->name, ['Botol', 'Kaleng'])) {
            return back()->withErrors(['category_id' => 'Hanya kategori Botol dan Kaleng yang diterima oleh sistem.']);
        }

        // Additional domain validation: Kaleng unit is gram, Botol unit is pcs
        if ($category->name === 'Kaleng' && $category->unit_type !== 'gram') {
            return back()->withErrors(['category_id' => 'Kategori Kaleng wajib menggunakan satuan gram.']);
        }

        if ($category->name === 'Botol' && $category->unit_type !== 'pcs') {
            return back()->withErrors(['category_id' => 'Kategori Botol wajib menggunakan satuan pcs.']);
        }

        // Create transaction with status 'pending' and 0 points earned until admin approval
        WasteTransaction::create([
            'user_id' => Auth::id(),
            'category_id' => $category->id,
            'quantity_or_weight' => $validated['quantity_or_weight'],
            'earned_points' => 0,
            'status' => 'pending',
            'grade_id' => null,
            'verified_by' => null,
            'notes' => null,
        ]);

        return redirect()->route('peserta.transactions.index')
            ->with('success', 'Setoran limbah ' . $category->name . ' berhasil diajukan dan sedang menunggu verifikasi serta penilaian grade oleh Admin.');
    }
}
