<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LocationController extends Controller
{
    /**
     * Semua admin (UPZ, BAZNAS, Super Admin) melihat seluruh lokasi.
     *
     * Sebelumnya admin UPZ difilter created_by = dirinya, sehingga lokasi
     * milik BAZNAS tidak terlihat sama sekali (hasilnya 0 lokasi).
     */
    private function scoped()
    {
        return Location::query();
    }

    /**
     * Semua admin boleh MELIHAT dan MENGUBAH lokasi mana pun.
     * Yang dibatasi hanya tipe lokasi yang boleh dibuat admin UPZ.
     */
    private function authorizeOwn(Location $location): void
    {
        // sengaja kosong — akses lihat & ubah dibuka untuk semua admin
    }

    /**
     * Hak hapus: hanya Super Admin dan Admin BAZNAS.
     * Admin UPZ hanya boleh melihat dan mengubah.
     */
    private function authorizeDelete(): void
    {
        abort_unless(
            Auth::user()->isSuperAdmin() || Auth::user()->isAdminBaznas(),
            403,
            'Admin UPZ hanya dapat melihat dan mengubah lokasi, tidak menghapus.'
        );
    }

    public function index()
    {
        $locations = $this->scoped()->latest()->paginate(10);
        $u = Auth::user();
        return view('dashboard.admin-locations', compact('locations', 'u'));
    }

    public function create()
    {
        return view('dashboard.admin-location-form', ['location' => new Location()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['created_by'] = Auth::id();
        // Admin UPZ tidak boleh membuat lokasi bertipe baznas
        if (Auth::user()->isAdminUpz() && $data['type'] === 'baznas') {
            $data['type'] = 'upz';
        }
        Location::create($data);
        $home = Auth::user()->isSuperAdmin() ? 'super.locations' : 'admin.locations.index';
        return redirect()->route($home)->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function edit(Location $location)
    {
        $this->authorizeOwn($location);
        return view('dashboard.admin-location-form', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $this->authorizeOwn($location);
        $data = $this->validated($request);
        if (Auth::user()->isAdminUpz() && $data['type'] === 'baznas') {
            $data['type'] = $location->type;
        }
        $location->update($data);
        $home = Auth::user()->isSuperAdmin() ? 'super.locations' : 'admin.locations.index';
        return redirect()->route($home)->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(Location $location)
    {
        $this->authorizeDelete();
        $location->delete();
        $home = Auth::user()->isSuperAdmin() ? 'super.locations' : 'admin.locations.index';
        return redirect()->route($home)->with('success', 'Lokasi berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'address' => ['required', 'string', 'max:255'],
            'kelurahan' => ['required', 'string', 'max:100'],
            'kecamatan' => ['required', 'string', 'max:100'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'type' => ['required', Rule::in(['baznas', 'upz', 'warga'])],
            'description' => ['nullable', 'string', 'max:500'],
            'phone' => ['nullable', 'string', 'max:30'],
            'opening_hours' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Nama lokasi wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'latitude.between' => 'Latitude harus antara -90 sampai 90.',
            'longitude.between' => 'Longitude harus antara -180 sampai 180.',
        ]) + ['is_active' => $request->boolean('is_active', true)];
    }
}
