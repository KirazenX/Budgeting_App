@extends('layouts.app', ['title' => 'Login'])

@section('content')

<div class="flex items-center justify-center min-h-screen bg-gray-100 p-4 sm:p-6">
    <div class="w-full max-w-4xl">
        
        <div class="bg-white shadow-2xl rounded-3xl overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2">
                
                <div class="hidden md:flex items-center justify-center p-8 lg:p-12 bg-light-green">
                    <div class="text-center w-full">
                        <h1 class="text-4xl lg:text-5xl font-extrabold text-primary-green mb-4 leading-tight">
                            💸 Kelola Cerdas.
                        </h1>
                        <p class="text-gray-600 text-lg">
                            Semua kendali finansial ada di genggaman Anda.
                        </p>
                    </div>
                </div>
                
                <div class="p-8 lg:p-10">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800">MASUK</h2>
                        <p class="text-gray-500 text-sm mt-1">Mulai atur pengeluaran Anda hari ini.</p>
                    </div>

                    <form action="{{ route('login') }}" method="POST" class="space-y-6">
                        @csrf
                        
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
                        
                        <button type="submit" 
                            class="w-full py-4 text-lg font-bold text-white bg-primary-green rounded-xl shadow-lg shadow-primary-green/50 hover:bg-emerald-700 transition duration-200 transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-emerald-300"
                        >
                            MASUK
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-6">
            <p class="text-gray-500 text-sm">
                Belum punya akun? 
                <a href="/register" class="font-bold text-primary-green hover:text-emerald-700 transition duration-200">
                    Daftar Sekarang
                </a>
            </p>
        </div>
    </div>
</div>

@endsection