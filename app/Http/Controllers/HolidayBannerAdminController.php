<?php

namespace App\Http\Controllers;

use App\Models\HolidayBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class HolidayBannerAdminController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();
        $banners = HolidayBanner::orderBy('event_date')->paginate(20);
        return view('dashboard.admin-holiday-banners', compact('banners'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $data = $this->validated($request);
        HolidayBanner::create($data);
        return back()->with('success', 'Banner hari raya berhasil ditambahkan.');
    }

    public function update(Request $request, HolidayBanner $banner)
    {
        $this->authorizeAdmin();
        $data = $this->validated($request);
        $banner->update($data);
        return back()->with('success', 'Banner hari raya berhasil diperbarui.');
    }

    public function toggle(HolidayBanner $banner)
    {
        $this->authorizeAdmin();
        $banner->update(['is_active' => !$banner->is_active]);
        return back()->with('success', 'Status banner diperbarui.');
    }

    public function destroy(HolidayBanner $banner)
    {
        $this->authorizeAdmin();
        $banner->delete();
        return back()->with('success', 'Banner hari raya dihapus.');
    }

    private function authorizeAdmin(): void
    {
        abort_unless(Auth::user()->isAdmin() || Auth::user()->isSuperAdmin(), 403);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'key' => ['required', 'string', 'max:60', Rule::unique('holiday_banners', 'key')->ignore($request->route('banner')?->id)],
            'name' => ['required', 'string', 'max:150'],
            'event_date' => ['required', 'date'],
            'before_days' => ['required', 'integer', 'min:0', 'max:90'],
            'after_days' => ['required', 'integer', 'min:0', 'max:90'],
            'icon' => ['required', 'string', 'max:60'],
            'color' => ['required', Rule::in(['olive', 'teal', 'blue', 'emerald', 'rose', 'gold'])],
            'title' => ['required', 'string', 'max:150'],
            'text' => ['required', 'string', 'max:2000'],
            'is_active' => ['nullable', 'boolean'],
        ]) + ['is_active' => $request->boolean('is_active', true)];
    }
}
