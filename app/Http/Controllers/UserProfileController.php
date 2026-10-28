<?php

namespace App\Http\Controllers;

use App\Models\CalculationHistory;
use App\Models\User;
use App\Models\WargaProfile;
use App\Models\ZakatRecord;
use App\Services\ZakatRecordExport;
use App\Services\Waris\WarisCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class UserProfileController extends Controller
{
    /**
     * Tampilkan profil user (data diri + kelola zakat).
     */
    public function index()
    {
        $u = Auth::user();
        $profile = $u->wargaProfile ?? $u->wargaProfile()->firstOrCreate(['user_id' => $u->id, 'full_name' => $u->name]);
        $records = $u->zakatRecords()->latest()->get();
        $histories = $u->calculationHistories()->latest()->get();

        return view('dashboard.user-profile', compact('profile', 'records', 'histories'));
    }

    /**
     * Edit data diri user.
     */
    public function edit()
    {
        $u = Auth::user();
        $profile = $u->wargaProfile ?? $u->wargaProfile()->firstOrCreate(['user_id' => $u->id, 'full_name' => $u->name]);
        return view('dashboard.user-profile-edit', compact('profile'));
    }

    /**
     * Simpan update data diri.
     */
    public function update(Request $request)
    {
        $u = Auth::user();
        $profile = $u->wargaProfile;

        // Jika belum ada, buat dulu
        if (!$profile) {
            $profile = $u->wargaProfile()->create(['user_id' => $u->id, 'full_name' => $u->name]);
        }

        $data = $request->validate([
            'nik' => ['required', 'string', 'max:16', 'unique:warga_profiles,nik,' . $profile->id],
            'gender' => ['required', 'string', 'in:male,female'],
            'birth_date' => ['required', 'date'],
            'birth_place' => ['required', 'string', 'max:100'],
            'marital_status' => ['required', 'string', 'in:single,married,divorced,widowed'],
            'phone' => ['required', 'string', 'max:20'],
            'occupation' => ['required', 'string', 'max:100'],
            'address_line1' => ['required', 'string', 'max:255'],
            'dependents_count' => ['required', 'integer', 'min:0', 'max:50'],
            'monthly_income' => ['required', 'numeric', 'min:0'],
            'monthly_expense' => ['required', 'numeric', 'min:0'],
            'debt_amount' => ['required', 'numeric', 'min:0'],
            'asset_value' => ['required', 'numeric', 'min:0'],
            'cash_value' => ['nullable', 'numeric', 'min:0'],
            'gold_value' => ['nullable', 'numeric', 'min:0'],
            'vehicle_value' => ['nullable', 'numeric', 'min:0'],
        ]);

        // Kategori otomatis — hitung di salinan, jangan rusak atribut $profile
        // (setRawAttributes() membuang id sehingga update() tak mengenai baris apa pun)
        $preview = new WargaProfile($data);
        $result = $preview->autoCategorize();
        $data['zakat_category'] = $result['category'];
        $data['zakat_category_reason'] = $result['reason'];

        $profile->update($data);

        return redirect()->route('user.profile')->with('success', 'Data diri berhasil diperbarui. Kategori zakat diperbarui otomatis.');
    }

    /**
     * Tambah catatan zakat manual.
     */
    public function storeRecord(Request $request)
    {
        $u = Auth::user();

        $data = $request->validate([
            'zakat_type' => ['required', 'in:zakat_fitrah,zakat_maal,fidyah,infak_sedekah,wariq'],
            'total_amount' => ['nullable', 'numeric', 'min:0'],
            'beras_kg' => ['nullable', 'numeric', 'min:0'],
            'gold_gram' => ['nullable', 'numeric', 'min:0'],
            'jiwa_count' => ['nullable', 'integer', 'min:1', 'max:100'],
            'due_date' => ['nullable', 'date'],
            'payment_date' => ['nullable', 'date'],
            'payment_method' => ['nullable', 'string', 'in:tunai,transfer,qris,beras_fisik,emas_fisik,makanan'],
            'reference_number' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:500'],
            'location_id' => ['nullable', 'exists:locations,id'],
        ]);

        $data['user_id'] = $u->id;
        $data['is_confirmed'] = false;
        ZakatRecord::create($data);

        return redirect()->route('user.profile')->with('success', 'Pencatatan zakat berhasil disimpan.');
    }

    /**
     * Hapus catatan zakat.
     */
    public function destroyRecord(ZakatRecord $record)
    {
        $u = Auth::user();
        abort_unless($record->user_id === $u->id, 403);
        $record->delete();
        return redirect()->route('user.profile')->with('success', 'Catatan zakat dihapus.');
    }

    /**
     * Riwayat perhitungan.
     */
    public function histories()
    {
        $u = Auth::user();
        $histories = $u->calculationHistories()->latest()->paginate(20);
        return view('dashboard.user-histories', compact('histories'));
    }

    /**
     * Ekspor catatan zakat ke Excel.
     */
    public function export(Request $request)
    {
        $u = Auth::user();

        // User biasa hanya export miliknya
        $userIds = [$u->id];

        // Jika admin, bisa export semua
        if ($u->isAdmin()) {
            $userIds = [];
        }

        $jenis = $request->get('jenis');

        return Excel::download(
            new ZakatRecordExport($userIds, $jenis),
            $request->get('filename', 'pencatatan-zakat.xlsx')
        );
    }

    /**
     * Hub kalkulator — semua kalkulator (fitrah, maal, fidyah, waris,
     * penghasilan, pertanian, perdagangan) dalam satu halaman.
     * Hasil tiap kalkulator dapat disimpan ke riwayat perhitungan.
     */
    public function calculators(Request $request)
    {
        $u = Auth::user();
        $beras = \App\Models\BerasPrice::currentPrice();
        $hargaEmas = 1_300_000; // estimasi default, bisa diisi user
        $tab = in_array($request->get('tab'), ['fitrah','maal','fidyah','penghasilan','pertanian','perdagangan','wariq'], true)
            ? $request->get('tab')
            : 'fitrah';

        return view('dashboard.user-calculators', compact('beras', 'hargaEmas', 'tab'));
    }

    /**
     * Hitung hasil kalkulator (penghasilan, pertanian, perdagangan, waris) di server.
     * Dipakai oleh hub untuk menampilkan hasil real-time tanpa menyimpan.
     *
     * @param  Request  $request
     * @param  string  $type
     */
    public function calculate(Request $request, string $type)
    {
        $allowedTypes = ['zakat_penghasilan', 'zakat_pertanian', 'zakat_perdagangan', 'wariq'];
        abort_unless(in_array($type, $allowedTypes, true), 400, 'Jenis perhitungan tidak valid.');

        $u = Auth::user();
        $save = $request->boolean('save'); // jika true, simpan otomatis ke riwayat
        $calc = new \App\Services\ZakatCalculator();

        if ($type === 'zakat_penghasilan') {
            $input = $request->validate([
                'penghasilan_bulan' => ['required', 'numeric', 'min:0'],
            ]);
            $result = $calc->penghasilan((float) $input['penghasilan_bulan']);
        }
        elseif ($type === 'zakat_pertanian') {
            $input = $request->validate([
                'hasil_panen_kg' => ['required', 'numeric', 'min:0'],
                'dengan_irigasi' => ['nullable', 'boolean'],
            ]);
            $result = $calc->pertanian(
                (float) $input['hasil_panen_kg'],
                (bool) ($input['dengan_irigasi'] ?? false)
            );
        }
        elseif ($type === 'zakat_perdagangan') {
            $input = $request->validate([
                'modal' => ['required', 'numeric', 'min:0'],
                'piutang' => ['nullable', 'numeric', 'min:0'],
                'persediaan' => ['nullable', 'numeric', 'min:0'],
                'utang' => ['nullable', 'numeric', 'min:0'],
                'harga_emas' => ['required', 'numeric', 'min:0'],
                'sudah_haul' => ['nullable', 'boolean'],
            ]);
            $result = $calc->perdagangan(
                (float) $input['modal'],
                (float) ($input['piutang'] ?? 0),
                (float) ($input['persediaan'] ?? 0),
                (float) ($input['utang'] ?? 0),
                (float) $input['harga_emas'],
                (bool) ($input['sudah_haul'] ?? true)
            );
        }
        elseif ($type === 'wariq') {
            $input = $request->validate([
                'total_harta' => ['required', 'numeric', 'min:0'],
                'hutang' => ['nullable', 'numeric', 'min:0'],
                'wasiat' => ['nullable', 'numeric', 'min:0'],
                'biaya_pemakaman' => ['nullable', 'numeric', 'min:0'],
                'pewaris_jk' => ['required', 'in:L,P'],
                'jumlah_anak_l' => ['nullable', 'integer', 'min:0', 'max:100'],
                'jumlah_anak_p' => ['nullable', 'integer', 'min:0', 'max:100'],
                'jumlah_cucu_l' => ['nullable', 'integer', 'min:0', 'max:100'],
                'jumlah_cucu_p' => ['nullable', 'integer', 'min:0', 'max:100'],
                'ada_ayah' => ['nullable', 'boolean'],
                'ada_ibu' => ['nullable', 'boolean'],
                'ada_kakek' => ['nullable', 'boolean'],
                'ada_nenek_ibu' => ['nullable', 'boolean'],
                'ada_nenek_ayah' => ['nullable', 'boolean'],
                'jumlah_saudara_l' => ['nullable', 'integer', 'min:0', 'max:100'],
                'jumlah_saudara_p' => ['nullable', 'integer', 'min:0', 'max:100'],
                'jumlah_saudara_seibu' => ['nullable', 'integer', 'min:0', 'max:100'],
                'ada_istri' => ['nullable', 'boolean'],
                'ada_suami' => ['nullable', 'boolean'],
            ]);

            $wariqCalc = new WarisCalculator();
            $result = $wariqCalc->hitung(
                totalHarta: (float) $input['total_harta'],
                pewarisJk: $input['pewaris_jk'],
                adaIstri: (bool) ($input['ada_istri'] ?? false),
                adaSuami: (bool) ($input['ada_suami'] ?? false),
                jumlahAnakL: (int) ($input['jumlah_anak_l'] ?? 0),
                jumlahAnakP: (int) ($input['jumlah_anak_p'] ?? 0),
                jumlahSaudaraL: (int) ($input['jumlah_saudara_l'] ?? 0),
                jumlahSaudaraP: (int) ($input['jumlah_saudara_p'] ?? 0),
                jumlahSaudaraSeibu: (int) ($input['jumlah_saudara_seibu'] ?? 0),
                jumlahCucuL: (int) ($input['jumlah_cucu_l'] ?? 0),
                jumlahCucuP: (int) ($input['jumlah_cucu_p'] ?? 0),
                adaAyah: (bool) ($input['ada_ayah'] ?? false),
                adaIbu: (bool) ($input['ada_ibu'] ?? false),
                adaKakek: (bool) ($input['ada_kakek'] ?? false),
                adaNenekIbu: (bool) ($input['ada_nenek_ibu'] ?? false),
                adaNenekAyah: (bool) ($input['ada_nenek_ayah'] ?? false),
                hutang: (float) ($input['hutang'] ?? 0),
                wasiat: (float) ($input['wasiat'] ?? 0),
                biayaPemakaman: (float) ($input['biaya_pemakaman'] ?? 0),
            );

            // Simpan otomatis jika diminta (pembeda kalkulator login vs publik)
            if ($save) {
                \App\Models\CalculationHistory::create([
                    'user_id' => $u->id,
                    'calc_type' => 'wariq',
                    'input_data' => $input,
                    'result_data' => $result,
                    'beras_price' => \App\Models\BerasPrice::currentPrice(),
                ]);
                $result['saved'] = true;
            }
        }

        // Simpan otomatis untuk kalkulator zakat (penghasilan/pertanian/perdagangan)
        if ($save && $type !== 'wariq') {
            $resultData = $result;
            $resultData['total'] = $result['zakat'] ?? ($result['zakat_bulanan'] ?? 0);
            \App\Models\CalculationHistory::create([
                'user_id' => $u->id,
                'calc_type' => $type,
                'input_data' => $input,
                'result_data' => $resultData,
                'beras_price' => \App\Models\BerasPrice::currentPrice(),
                'gold_price' => $result['nisab'] ?? null,
            ]);
            $result['saved'] = true;
        }

        return response()->json($result);
    }

    /**
     * Simpan hasil kalkulator ke riwayat perhitungan.
     *
     * @param  Request  $request
     * @param  string  $type  zakat_fitrah | zakat_maal | fidyah | wariq |
     *                        zakat_penghasilan | zakat_pertanian | zakat_perdagangan
     */
    public function saveCalculation(Request $request, string $type)
    {
        $allowedTypes = [
            'zakat_fitrah', 'zakat_maal', 'fidyah', 'wariq',
            'zakat_penghasilan', 'zakat_pertanian', 'zakat_perdagangan',
        ];
        abort_unless(in_array($type, $allowedTypes, true), 400, 'Jenis perhitungan tidak valid.');

        $u = Auth::user();

        $request->validate([
            'input_data' => ['required', 'array'],
            'result_data' => ['nullable', 'array'],
        ]);

        // Masukkan total nilai ke dalam result_data agar ikut tersimpan & tampil di riwayat
        $resultData = $request->input('result_data', []);

        // Field bersarang dikirim sebagai JSON string — decode agar tersimpan sebagai array
        // (kalau tidak, riwayat waris gagal menampilkan tabel hasil).
        foreach ($resultData as $key => $val) {
            if (!is_string($val)) {
                continue;
            }
            $trimmed = trim($val);
            if (!str_starts_with($trimmed, '[') && !str_starts_with($trimmed, '{')) {
                continue;
            }
            $decoded = json_decode($val, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $resultData[$key] = $decoded;
            }
        }

        if ($request->filled('total_nilai')) {
            $resultData['total'] = (float) $request->input('total_nilai');
        }

        \App\Models\CalculationHistory::create([
            'user_id' => $u->id,
            'calc_type' => $type,
            'input_data' => $request->input('input_data', []),
            'result_data' => $resultData,
            'beras_price' => \App\Models\BerasPrice::currentPrice(),
            'gold_price' => $request->filled('gold_price') ? (float) $request->input('gold_price') : null,
        ]);

        return back()->with('success', 'Perhitungan berhasil disimpan ke riwayat.');
    }
}
