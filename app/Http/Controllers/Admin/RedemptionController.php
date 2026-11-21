<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PointRedemption;
use Illuminate\Http\Request;

class RedemptionController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = PointRedemption::with('user')->latest();

        if ($status && in_array($status, ['pending', 'completed'])) {
            $query->where('status', $status);
        }

        $redemptions = $query->paginate(10)->withQueryString();

        return view('admin.redemptions.index', compact('redemptions', 'status'));
    }

    public function complete(PointRedemption $redemption)
    {
        if ($redemption->status === 'completed') {
            return back()->with('error', 'Penukaran poin ini sudah diselesaikan sebelumnya.');
        }

        $redemption->update([
            'status' => 'completed',
        ]);

        return back()->with('success', 'Penukaran poin #' . $redemption->id . ' sebesar Rp ' . number_format($redemption->rupiah_amount, 0, ',', '.') . ' berhasil ditandai selesai.');
    }
}
