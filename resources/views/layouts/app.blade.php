<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }} | EasyBudget</title>

    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body { font-family: 'Inter', sans-serif; }

        .custom-scrollbar::-webkit-scrollbar { width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #4b5563; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #111827; }
    </style>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-green': '#059669',
                        'light-green': '#ECFDF5',
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 antialiased">

    @auth
    <div id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-gray-900 text-white p-5 space-y-4 custom-scrollbar transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-50">
        <h4 class="text-2xl font-extrabold mb-8 text-primary-green">{{ config('app.name') }}</h4>

        <nav class="space-y-2">
            @php
                // Data navigasi dengan ikon SVG (Icon Path dari Lucide/Heroicons)
                $navItems = [
                    ['route' => '/dashboard', 'label' => 'Dashboard', 'icon' => 'M3 4h18M3 10h18M3 16h18'], 
                    ['route' => '/transactions', 'label' => 'Transaksi', 'icon' => 'M12 8c-1.66 0-3 1.34-3 3v5h6v-5c0-1.66-1.34-3-3-3z'],
                    ['route' => '/categories', 'label' => 'Kategori', 'icon' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-4.414-4.414A1 1 0 0013.586 4H7a2 2 0 00-2 2v13a2 2 0 002 2z'],
                    ['route' => '/budgets', 'label' => 'Anggaran', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['route' => '/reports', 'label' => 'Laporan', 'icon' => 'M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z'],
                    ['route' => '/settings', 'label' => 'Pengaturan', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065zM12 15a3 3 0 100-6 3 3 0 000 6z'],
                ];
            @endphp
            @foreach($navItems as $item)
                <a href="{{ $item['route'] }}" class="flex items-center p-3 rounded-xl transition duration-200 hover:bg-gray-800 {{ Request::is(trim($item['route'], '/').'*') ? 'bg-primary-green text-white hover:bg-emerald-700' : 'text-gray-300' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                    </svg>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>
        
        <div class="pt-4 border-t border-gray-700 mt-auto">
            <a href="#" onclick="event.preventDefault(); openLogoutModal();" class="flex items-center p-3 rounded-xl transition duration-200 text-red-400 hover:bg-gray-800">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>
    
    <button id="menu-toggle" class="md:hidden fixed top-4 left-4 z-50 p-3 rounded-xl bg-gray-900 text-white shadow-lg focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
    </button>
    @endauth

    <main id="content" class="min-h-screen p-6 md:p-8 transition-all duration-300 ease-in-out @auth md:ml-64 @endauth">
        @yield('content')
    </main>

    @auth
        <div id="logout-modal" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-[60]">
            <div class="bg-white w-full max-w-md rounded-2xl shadow-xl border border-gray-200">
                <div class="p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mr-3">
                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 9v2m0 4h.01M12 19a7 7 0 100-14 7 7 0 000 14z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">Konfirmasi Logout</h4>
                            <p class="text-sm text-gray-600 mt-1">Anda yakin ingin keluar dari EasyBudget? Anda dapat login kembali kapan saja.</p>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3">
                        <button type="button" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200" onclick="closeLogoutModal()">Batal</button>
                        <button type="button" class="px-4 py-2 text-sm font-semibold text-white bg-red-500 rounded-lg shadow hover:bg-red-600" onclick="performLogout()">Logout</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="delete-modal" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-[60]">
            <div class="bg-white w-full max-w-md rounded-2xl shadow-xl border border-gray-200">
                <div class="p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mr-3">
                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a2 2 0 012 2v2H8V5a2 2 0 012-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">Konfirmasi Hapus</h4>
                            <p id="delete-modal-message" class="text-sm text-gray-600 mt-1">Apakah Anda yakin ingin menghapus item ini?</p>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3">
                        <button type="button" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200" onclick="closeDeleteModal()">Batal</button>
                        <button type="button" class="px-4 py-2 text-sm font-semibold text-white bg-red-500 rounded-lg shadow hover:bg-red-600" onclick="confirmDelete()">Hapus</button>
                    </div>
                </div>
            </div>
        </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const menuToggle = document.getElementById('menu-toggle');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            if (!sidebar.classList.contains('-translate-x-full')) {
            }
        });

        // Modal-based, themed logout confirmation
        function openLogoutModal(){
            const modal = document.getElementById('logout-modal');
            if(!modal) return;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeLogoutModal(){
            const modal = document.getElementById('logout-modal');
            if(!modal) return;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function performLogout(){
            const form = document.getElementById('logout-form');
            if(form) form.submit();
        }

        // Backward compat: existing calls
        function confirmLogout(){
            openLogoutModal();
        }

        // Generic delete confirmation modal
        let __pendingDeleteForm = null;
        function openDeleteModal(message){
            const modal = document.getElementById('delete-modal');
            const msgEl = document.getElementById('delete-modal-message');
            if(msgEl && message) msgEl.textContent = message;
            if(!modal) return;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function closeDeleteModal(){
            const modal = document.getElementById('delete-modal');
            if(!modal) return;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            __pendingDeleteForm = null;
        }
        function confirmDelete(){
            if(__pendingDeleteForm){
                __pendingDeleteForm.submit();
            }
            closeDeleteModal();
        }

        document.addEventListener('DOMContentLoaded', function(){
            const forms = document.querySelectorAll('form[data-confirm="delete"]');
            forms.forEach(function(f){
                f.addEventListener('submit', function(e){
                    e.preventDefault();
                    __pendingDeleteForm = f;
                    const msg = f.getAttribute('data-message') || 'Apakah Anda yakin ingin menghapus item ini?';
                    openDeleteModal(msg);
                });
            });
        });
    </script>
    @endauth
    
    @yield('scripts')
</body>
</html>