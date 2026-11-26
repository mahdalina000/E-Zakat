@extends('layouts.dashboard')
@section('title', __('Pengaturan Super Admin — E-Zakat'))
@section('page-title', __('Pengaturan Super Admin'))
@section('page-sub', __('Atur preferensi akun serta notifikasi Anda'))
@section('content')
<div class="settings-page p-5 lg:p-8 w-full">
    @include('settings.partials.profile-header')
    <div class="mt-6">
        @include('settings.partials.account-options')
    </div>
</div>
@endsection
