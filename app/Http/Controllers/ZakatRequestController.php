<?php

namespace App\Http\Controllers;

use App\Models\ZakatRequest;
use App\Models\Location;
use App\Services\Waris\WarisCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ZakatRequestController extends Controller
{
    /**
     * Halaman pengajuan masyarakat (user).
     */
    public function index()
    {
        $requests = ZakatRequest::where('user_id', Auth::id())
            ->with('verifier', 'calculator')
            ->latest()->paginate(20);
        $locations = Location::where('is_active', true)->orderBy('name')->get();
        return view('dashboard.user-zakat-request', compact('requests', 'locations'));
    }

    /**
     * Simpan pengajuan baru (perhitungan WARIS).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'deceased_name' => ['required', 'string', 'max:255'],
            'total_harta' => ['required', 'numeric', 'min:0'],
            'hutang' => ['nullable', 'numeric', 'min:0'],
            'biaya_pemakaman' => ['nullable', 'numeric', 'min:0'],
            'wasiat' => ['nullable', 'numeric', 'min:0'],
            'harta_sengketa' => ['nullable', 'numeric', 'min:0'],
            'pewaris_jk' => ['required', 'in:L,P'],
            'jumlah_anak_l' => ['nullable', 'integer', 'min:0', 'max:100'],
            'jumlah_anak_p' => ['nullable', 'integer', 'min:0', 'max:100'],
            'jumlah_cucu_l' => ['nullable', 'integer', 'min:0', 'max:100'],
            'jumlah_cucu_p' => ['nullable', 'integer', 'min:0', 'max:100'],
            'jumlah_saudara_l' => ['nullable', 'integer', 'min:0', 'max:100'],
            'jumlah_saudara_p' => ['nullable', 'integer', 'min:0', 'max:100'],
            'jumlah_saudara_seibu' => ['nullable', 'integer', 'min:0', 'max:100'],
            'ada_ayah' => ['nullable', 'boolean'],
            'ada_ibu' => ['nullable', 'boolean'],
            'ada_kakek' => ['nullable', 'boolean'],
            'ada_nenek_ibu' => ['nullable', 'boolean'],
            'ada_nenek_ayah' => ['nullable', 'boolean'],
            'ada_istri' => ['nullable', 'boolean'],
            'jumlah_istri' => ['nullable', 'integer', 'min:1', 'max:4'],
            'ada_suami' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', 'max:2000'],
            'location_id' => ['nullable', 'exists:locations,id'],
        ]);

        $waris = [
            'pewaris_jk' => $data['pewaris_jk'],
            'total_harta' => (float) $data['total_harta'],
            'hutang' => (float) ($data['hutang'] ?? 0),
            'biaya_pemakaman' => (float) ($data['biaya_pemakaman'] ?? 0),
            'wasiat' => (float) ($data['wasiat'] ?? 0),
            'harta_sengketa' => (float) ($data['harta_sengketa'] ?? 0),
            'jumlah_anak_l' => (int) ($data['jumlah_anak_l'] ?? 0),
            'jumlah_anak_p' => (int) ($data['jumlah_anak_p'] ?? 0),
            'jumlah_cucu_l' => (int) ($data['jumlah_cucu_l'] ?? 0),
            'jumlah_cucu_p' => (int) ($data['jumlah_cucu_p'] ?? 0),
            'jumlah_saudara_l' => (int) ($data['jumlah_saudara_l'] ?? 0),
            'jumlah_saudara_p' => (int) ($data['jumlah_saudara_p'] ?? 0),
            'jumlah_saudara_seibu' => (int) ($data['jumlah_saudara_seibu'] ?? 0),
            'ada_ayah' => (bool) ($data['ada_ayah'] ?? false),
            'ada_ibu' => (bool) ($data['ada_ibu'] ?? false),
            'ada_kakek' => (bool) ($data['ada_kakek'] ?? false),
            'ada_nenek_ibu' => (bool) ($data['ada_nenek_ibu'] ?? false),
            'ada_nenek_ayah' => (bool) ($data['ada_nenek_ayah'] ?? false),
            'ada_istri' => (bool) ($data['ada_istri'] ?? false),
            'jumlah_istri' => (int) ($data['jumlah_istri'] ?? 1),
            'ada_suami' => (bool) ($data['ada_suami'] ?? false),
        ];

        ZakatRequest::create([
            'user_id' => Auth::id(),
            'location_id' => $data['location_id'] ?? null,
            'full_name' => Auth::user()->name,
            'deceased_name' => $data['deceased_name'],
            'total_assets' => (float) $data['total_harta'],
            'debt_amount' => (float) ($data['hutang'] ?? 0),
            'monthly_income' => 0,
            'family_members' => 0,
            'description' => $data['description'] ?? null,
            'waris_data' => $waris,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pengajuan hitung waris berhasil dikirim. Admin akan memverifikasi lalu menghitung pembagian waris.');
    }

    /**
     * Hak akses: admin UPZ/BAZNAS.
     */
    private function ensureAdmin()
    {
        abort_unless(Auth::user()->isAdmin(), 403);
    }

    /**
     * Antrean pengajuan di sisi admin.
     */
    public function adminIndex()
    {
        $this->ensureAdmin();
        $q = request('status');
        $requests = ZakatRequest::with('user', 'verifier', 'calculator')
            ->when($q, fn ($x) => $x->where('status', $q))
            ->latest()->paginate(15)->withQueryString();
        return view('dashboard.admin-zakat-requests', compact('requests', 'q'));
    }

    /**
     * Verifikasi pengajuan oleh admin.
     */
    public function verify(ZakatRequest $zakatRequest)
    {
        $this->ensureAdmin();
        $zakatRequest->update([
            'status' => 'verified',
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);
        return back()->with('success', 'Pengajuan diverifikasi. Silakan hitung zakatnya.');
    }

    /**
     * Admin menghitung pembagian WARIS pengajuan (otomatis, sesuai kalkulator waris).
     */
    public function calculate(Request $request, ZakatRequest $zakatRequest)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ]);

        $w = (array) $zakatRequest->waris_data;

        if (empty($w) || !isset($w['total_harta'])) {
            return back()->withErrors(['waris' => 'Data pengajuan waris tidak lengkap.']);
        }

        // Harta sengketa dikeluarkan dari total sebelum dibagi (belum bisa dibagikan)
        $hartaSengketa = max(0, (float) ($w['harta_sengketa'] ?? 0));
        $totalHartaEfektif = max(0, (float) $w['total_harta'] - $hartaSengketa);

        $calc = new WarisCalculator();
        $result = $calc->hitung(
            totalHarta: $totalHartaEfektif,
            pewarisJk: $w['pewaris_jk'] ?? 'L',
            adaIstri: (bool) ($w['ada_istri'] ?? false),
            adaSuami: (bool) ($w['ada_suami'] ?? false),
            jumlahIstri: (int) ($w['jumlah_istri'] ?? 1),
            jumlahAnakL: (int) ($w['jumlah_anak_l'] ?? 0),
            jumlahAnakP: (int) ($w['jumlah_anak_p'] ?? 0),
            jumlahSaudaraL: (int) ($w['jumlah_saudara_l'] ?? 0),
            jumlahSaudaraP: (int) ($w['jumlah_saudara_p'] ?? 0),
            jumlahSaudaraSeibu: (int) ($w['jumlah_saudara_seibu'] ?? 0),
            jumlahCucuL: (int) ($w['jumlah_cucu_l'] ?? 0),
            jumlahCucuP: (int) ($w['jumlah_cucu_p'] ?? 0),
            adaAyah: (bool) ($w['ada_ayah'] ?? false),
            adaIbu: (bool) ($w['ada_ibu'] ?? false),
            adaKakek: (bool) ($w['ada_kakek'] ?? false),
            adaNenekIbu: (bool) ($w['ada_nenek_ibu'] ?? false),
            adaNenekAyah: (bool) ($w['ada_nenek_ayah'] ?? false),
            hutang: (float) ($w['hutang'] ?? 0),
            wasiat: (float) ($w['wasiat'] ?? 0),
            biayaPemakaman: (float) ($w['biaya_pemakaman'] ?? 0),
        );

        $hartaBersih = (float) ($result['hartaBersih'] ?? $result['harta_bersih'] ?? 0);

        // Simpan dokumentasi sengketa agar tampil di hasil
        $result['totalHartaAsli'] = (float) $w['total_harta'];
        $result['hartaSengketa'] = $hartaSengketa;

        $zakatRequest->update([
            'status' => 'done',
            'calculated_amount' => $hartaBersih,
            'calculation_detail' => $result,
            'admin_note' => $data['admin_note'] ?? $zakatRequest->admin_note,
            'calculated_by' => Auth::id(),
            'calculated_at' => now(),
        ]);

        return back()->with('success', 'Pembagian waris telah dihitung dan hasilnya terkirim ke warga.');
    }

    /**
     * Tolak pengajuan.
     */
    public function reject(Request $request, ZakatRequest $zakatRequest)
    {
        $this->ensureAdmin();
        $data = $request->validate([
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ]);
        $zakatRequest->update([
            'status' => 'rejected',
            'admin_note' => $data['admin_note'] ?? $zakatRequest->admin_note,
            'rejected_at' => now(),
        ]);
        return back()->with('success', 'Pengajuan ditolak.');
    }

    /**
     * Hapus pengajuan (user yang punya).
     */
    public function destroy(ZakatRequest $zakatRequest)
    {
        abort_unless($zakatRequest->user_id === Auth::id(), 403);
        $zakatRequest->delete();
        return back()->with('success', 'Pengajuan dihapus.');
    }
}
