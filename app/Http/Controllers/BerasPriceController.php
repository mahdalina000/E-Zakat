<?php

namespace App\Http\Controllers;

use App\Models\BerasPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerasPriceController extends Controller
{
    public function index()
    {
        $current = BerasPrice::current();
        $history = BerasPrice::with('updater')->latest('id')->paginate(10);
        return view('dashboard.admin-beras', compact('current', 'history'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'price' => ['required', 'integer', 'min:5000', 'max:100000'],
            'note' => ['nullable', 'string', 'max:200'],
        ], [
            'price.required' => 'Harga wajib diisi.',
            'price.integer' => 'Harga harus berupa angka.',
            'price.min' => 'Harga minimal Rp5.000/kg — periksa kembali, tampaknya tidak valid.',
            'price.max' => 'Harga maksimal Rp100.000/kg — periksa kembali, tampaknya tidak valid.',
        ]);

        BerasPrice::create([
            'price' => $data['price'],
            'note' => $data['note'] ?? 'Pembaruan harga',
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.beras.index')->with('success', 'Harga Beras Banjar berhasil diperbarui menjadi Rp' . number_format($data['price'], 0, ',', '.') . '/kg.');
    }
}
