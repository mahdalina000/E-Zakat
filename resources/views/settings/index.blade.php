@extends('layouts.dashboard')
@section('title', __('Pengaturan — E-Zakat'))
@section('page-title', __('Pengaturan Akun'))
@section('page-sub', __('Kelola preferensi bahasa, tema, dan keamanan akun Anda'))

@section('content')
<div class="settings-page p-5 lg:p-8 w-full">
    @include('settings.partials.account-options')
</div>
@endsection
