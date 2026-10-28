<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WargaProfile;
use App\Models\ZakatRecord;
use App\Services\ZakatRecordExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AdminBaznasController extends Controller
{
    /**
     * Dashboard admin BAZNAS/UPZ: kelola warga & penerima zakat.
     */
    public function index()
    {
        $u = Auth::user();

        $warga = User::where('role', 'user')->with('wargaProfile')
            ->orderBy('name')->paginate(15);

        $totalPenerima = User::where('role', 'user')
            ->whereHas('wargaProfile', fn ($q) => $q->whereIn('zakat_category', ['penerima_fakir', 'penerima_miskin', 'penerima_gharimin']))
            ->count();

        $totalPemberi = User::where('role', 'user')
            ->whereHas('wargaProfile', fn ($q) => $q->where('zakat_category', 'pemberi'))
            ->count();

        $totalRecords = ZakatRecord::count();

        return view('dashboard.admin-baznas', compact('warga', 'totalPenerima', 'totalPemberi', 'totalRecords'));
    }

    /**
     * Tambah warga penerima zakat (buat user + profile sekaligus).
     */
    public function storeWarga(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'nik' => ['required', 'string', 'max:16', 'unique:warga_profiles,nik'],
            'gender' => ['required', 'string', 'in:male,female'],
            'birth_date' => ['required', 'date'],
            'birth_place' => ['required', 'string', 'max:100'],
            'marital_status' => ['required', 'string', 'in:single,married,divorced,widowed'],
            'occupation' => ['required', 'string', 'max:100'],
            'dependents_count' => ['required', 'integer', 'min:0', 'max:50'],
            'monthly_income' => ['required', 'numeric', 'min:0'],
            'monthly_expense' => ['required', 'numeric', 'min:0'],
            'debt_amount' => ['required', 'numeric', 'min:0'],
            'asset_value' => ['required', 'numeric', 'min:0'],
            'address_line1' => ['required', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'user',
            'is_active' => true,
        ]);

        $profile = new WargaProfile([
            'user_id' => $user->id,
            'full_name' => $data['name'],
            'nik' => $data['nik'],
            'gender' => $data['gender'],
            'birth_date' => $data['birth_date'],
            'birth_place' => $data['birth_place'],
            'marital_status' => $data['marital_status'],
            'occupation' => $data['occupation'],
            'dependents_count' => $data['dependents_count'],
            'monthly_income' => $data['monthly_income'],
            'monthly_expense' => $data['monthly_expense'],
            'debt_amount' => $data['debt_amount'],
            'asset_value' => $data['asset_value'],
            'address_line1' => $data['address_line1'],
        ]);

        // Kategorisasi otomatis
        $result = $profile->autoCategorize();
        $profile->zakat_category = $result['category'];
        $profile->zakat_category_reason = $result['reason'];
        $profile->save();

        return redirect()->route('admin.baznas')->with('success', "Warga {$data['name']} berhasil ditambahkan sebagai penerima zakat.");
    }

    /**
     * Tampilkan detail warga (termasuk profil + catatan).
     */
    public function showWarga(User $user)
    {
        $profile = $user->wargaProfile;
        $records = $user->zakatRecords()->latest()->get();
        $locations = \App\Models\Location::where('is_active', true)->orderBy('name')->get();
        return view('dashboard.admin-warga-detail', compact('user', 'profile', 'records', 'locations'));
    }

    /**
     * Edit data warga (profil).
     */
    public function editWarga(User $user)
    {
        $profile = $user->wargaProfile ?? $user->wargaProfile()->firstOrCreate(['user_id' => $user->id, 'full_name' => $user->name]);
        return view('dashboard.admin-warga-edit', compact('user', 'profile'));
    }

    /**
     * Simpan edit warga.
     */
    public function updateWarga(Request $request, User $user)
    {
        $profile = $user->wargaProfile;
        if (!$profile) {
            $profile = $user->wargaProfile()->create(['user_id' => $user->id, 'full_name' => $user->name]);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'max:16', 'unique:warga_profiles,nik,' . $profile->id],
            'gender' => ['required', 'string', 'in:male,female'],
            'birth_date' => ['required', 'date'],
            'birth_place' => ['required', 'string', 'max:100'],
            'marital_status' => ['required', 'string', 'in:single,married,divorced,widowed'],
            'occupation' => ['required', 'string', 'max:100'],
            'dependents_count' => ['required', 'integer', 'min:0', 'max:50'],
            'monthly_income' => ['required', 'numeric', 'min:0'],
            'monthly_expense' => ['required', 'numeric', 'min:0'],
            'debt_amount' => ['required', 'numeric', 'min:0'],
            'asset_value' => ['required', 'numeric', 'min:0'],
            'address_line1' => ['required', 'string', 'max:255'],
        ]);

        // Kategori otomatis — hitung di salinan, jangan rusak atribut $profile
        // (setRawAttributes() membuang id sehingga update() tak mengenai baris apa pun)
        $preview = new WargaProfile($data);
        $result = $preview->autoCategorize();
        $data['zakat_category'] = $result['category'];
        $data['zakat_category_reason'] = $result['reason'];

        // Update nama akun user + hapus dari data profil (warga_profiles pakai full_name)
        $user->update(['name' => $data['name']]);
        unset($data['name']);

        $profile->update($data);

        return redirect()->route('admin.baznas')->with('success', "Data warga {$user->name} berhasil diperbarui.");
    }

    /**
     * Tambah catatan zakat oleh admin (untuk warga tertentu).
     */
    public function storeRecord(Request $request, User $user)
    {
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

        $data['user_id'] = $user->id;
        $data['is_confirmed'] = false;
        ZakatRecord::create($data);

        return redirect()->route('admin.baznas')->with('success', "Catatan zakat untuk {$user->name} berhasil disimpan.");
    }

    /**
     * Hapus catatan zakat (admin).
     */
    public function destroyRecord(ZakatRecord $record)
    {
        $record->delete();
        return redirect()->route('admin.baznas')->with('success', 'Catatan zakat dihapus.');
    }

    /**
     * Ekspor semua catatan zakat (admin) ke Excel.
     */
    public function export(Request $request)
    {
        $u = Auth::user();
        abort_unless($u->isAdmin(), 403);

        $jenis = $request->get('jenis');
        $userIds = [];

        return Excel::download(
            new ZakatRecordExport($userIds, $jenis),
            'pencatatan-zakat-admin-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
