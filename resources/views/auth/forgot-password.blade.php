@extends('layouts.app', ['title' => 'Lupa Password'])

@section('content')

<div class="flex items-center justify-center min-h-screen bg-gray-100 p-4 sm:p-6">
    <div class="w-full max-w-md">
        
        <!-- Card Container - Modern Shadow -->
        <div class="bg-white shadow-2xl rounded-3xl p-6 sm:p-8 lg:p-10">
            
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">LUPA PASSWORD?</h2>
                <p class="text-gray-500 text-sm mt-1">Kami akan mengirimkan tautan reset ke email Anda.</p>
            </div>

            @if (session('status'))
            <!-- Success Alert Styling -->
            <div class="bg-light-green border-l-4 border-primary-green text-green-800 p-4 rounded-lg mb-6" role="alert">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div>
                    <input id="email" type="email" 
                        class="w-full p-4 text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:ring-primary-green focus:border-primary-green transition duration-200 
                            @error('email') border-red-500 ring-red-500 @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                        placeholder="Masukkan Alamat Email Anda">

                    @error('email')
                    <div class="text-red-500 text-xs mt-1">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                </div>

                <!-- Submit Button - Consistent Green CTA -->
                <button type="submit" 
                    class="w-full py-4 text-lg font-bold text-white bg-primary-green rounded-xl shadow-lg shadow-primary-green/50 hover:bg-emerald-700 transition duration-200 transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-emerald-300"
                >
                    KIRIM TAUTAN RESET
                </button>
            </form>
            
            <hr class="my-6 border-gray-200">

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-primary-green transition duration-200">
                    &larr; Kembali ke Halaman Login
                </a>
            </div>
        </div>
    </div>
</div>

@endsection