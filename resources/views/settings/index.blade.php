@extends('layouts.app', ['title' => 'Pengaturan'])

@section('content')
<div class="p-4 md:p-6 lg:p-8">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-6">Pengaturan</h2>

    <div class="max-w-xl">
        <div class="bg-white shadow-xl rounded-2xl p-6">
            <h5 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-3">Pengaturan Akun</h5>

            <div class="mb-6">
                <div class="text-sm font-medium text-gray-500">Masuk sebagai</div>
                <div class="text-lg font-bold text-gray-800">{{ auth()->user()->name }} <span class="text-gray-500 font-normal text-base">&lt;{{ auth()->user()->email }}&gt;</span></div>
            </div>

            <hr class="border-gray-200 my-4">

            <!-- Logout Section -->
            <div class="flex items-center justify-between p-2 rounded-xl hover:bg-red-50 transition duration-150">
                <div>
                    <div class="font-bold text-gray-700">Keluar dari Aplikasi</div>
                    <div class="text-sm text-gray-500">Anda akan keluar dari sesi saat ini dan membutuhkan login kembali.</div>
                </div>
                <button type="button" onclick="openLogoutModal()" class="px-4 py-2 text-sm font-semibold text-white bg-red-500 rounded-lg shadow-md hover:bg-red-600 transition duration-200">
                    Logout
                </button>
            </div>
        </div>
    </div>
</div>
@endsection