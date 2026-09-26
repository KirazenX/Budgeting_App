@extends('layouts.app', ['title' => 'Register'])

@section('content')

<div class="flex items-center justify-center min-h-screen bg-gray-100 p-4 sm:p-6">
    <div class="w-full max-w-5xl">
        
        <div class="bg-white shadow-2xl rounded-3xl overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-7">
                <div class="hidden md:flex md:col-span-3 items-center justify-center p-8 lg:p-12 bg-light-green">
                    <div class="text-center w-full">
                        <h1 class="text-4xl lg:text-5xl font-extrabold text-primary-green mb-4 leading-tight">
                            🚀 Mulai Perjalanan Anda.
                        </h1>
                        <p class="text-gray-600 text-lg">
                            Daftar hari ini dan raih kontrol penuh atas keuangan Anda.
                        </p>
                    </div>
                </div>
                
                <div class="md:col-span-4 p-8 lg:p-10">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800">BUAT AKUN BARU</h2>
                        <p class="text-gray-500 text-sm mt-1">Cepat, mudah, dan siap untuk budgeting.</p>
                    </div>

                    <form action="{{ route('register') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <input type="text" name="name" value="{{ old('name') }}" 
                                class="w-full p-4 text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:ring-primary-green focus:border-primary-green transition duration-200 
                                    @error('name') border-red-500 ring-red-500 @enderror" 
                                placeholder="Nama Lengkap Anda"
                            >
                            @error('name')
                                <div class="text-red-500 text-xs mt-1">
                                    {{ $message }}
                                </div>    
                            @enderror
                        </div>

                        <div>
                            <input type="email" name="email" value="{{ old('email') }}" 
                                class="w-full p-4 text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:ring-primary-green focus:border-primary-green transition duration-200 
                                    @error('email') border-red-500 ring-red-500 @enderror" 
                                placeholder="Alamat Email"
                            >
                            @error('email')
                                <div class="text-red-500 text-xs mt-1">
                                    {{ $message }}
                                </div>    
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <input type="password" name="password" 
                                    class="w-full p-4 text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:ring-primary-green focus:border-primary-green transition duration-200
                                        @error('password') border-red-500 ring-red-500 @enderror" 
                                    placeholder="Password"
                                >
                                @error('password')
                                    <div class="text-red-500 text-xs mt-1">
                                        {{ $message }}
                                    </div>    
                                @enderror
                            </div>
                            
                            <div>
                                <input type="password" name="password_confirmation" 
                                    class="w-full p-4 text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:ring-primary-green focus:border-primary-green transition duration-200" 
                                    placeholder="Konfirmasi Password"
                                >
                            </div>
                        </div>
                        
                        <button type="submit" 
                            class="w-full py-4 text-lg font-bold text-white bg-primary-green rounded-xl shadow-lg shadow-primary-green/50 hover:bg-emerald-700 transition duration-200 transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-emerald-300 mt-4"
                        >
                            DAFTAR
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-6">
            <p class="text-gray-500 text-sm">
                Sudah punya akun? 
                <a href="/login" class="font-bold text-primary-green hover:text-emerald-700 transition duration-200">
                    Login Disini
                </a>
            </p>
        </div>
    </div>
</div>

@endsection