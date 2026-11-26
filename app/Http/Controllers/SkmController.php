<?php

namespace App\Http\Controllers;

use App\Models\SkmResponse;
use Illuminate\Http\Request;

class SkmController extends Controller
{
    public const QUESTIONS = [
        '1. Bagaimana Anda menilai kemudahan proses pendaftaran/pengajuan layanan?',
        '2. Bagaimana kecepatan pelayanan yang Anda terima?',
        '3. Bagaimana keramahan dan kesopanan petugas dalam melayani?',
        '4. Bagaimana kejelasan informasi yang diberikan kepada Anda?',
        '5. Bagaimana kemudahan akses layanan digital (website) E-Zakat?',
        '6. Bagaimana kesesuaian hasil layanan dengan kebutuhan Anda?',
        '7. Bagaimana kualitas sarana dan fasilitas penunjang layanan?',
        '8. Bagaimana ketepatan waktu penyelesaian layanan?',
        '9. Bagaimana ketersediaan sarana pengaduan/keluhan?',
        '10. Bagaimana penilaian Anda secara keseluruhan terhadap layanan E-Zakat?',
    ];

    public function index()
    {
        return view('skm.index', ['questions' => self::QUESTIONS]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'answers' => ['required', 'array', 'size:10'],
            'answers.*' => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string', 'max:2000'],
        ]);

        SkmResponse::create([
            'user_id' => auth()->id(),
            'answers' => array_values($data['answers']),
            'comment' => $data['comment'] ?? null,
        ]);

        return redirect()->route('skm.index')->with('success', __('Terima kasih! Jawaban survei Anda telah tersimpan.'));
    }

    public function adminSummary()
    {
        $responses = SkmResponse::with('user')->orderByDesc('created_at')->get();
        $count = $responses->count();
        $averages = [];

        if ($count > 0) {
            foreach (self::QUESTIONS as $i => $q) {
                $sum = 0; $n = 0;
                foreach ($responses as $rsp) {
                    if (isset($rsp->answers[$i])) { $sum += (int) $rsp->answers[$i]; $n++; }
                }
                $averages[$i] = $n ? round($sum / $n, 2) : 0;
            }
        }

        return view('admin.skm-summary', [
            'responses' => $responses,
            'count' => $count,
            'averages' => $averages,
            'questions' => self::QUESTIONS,
        ]);
    }
}
