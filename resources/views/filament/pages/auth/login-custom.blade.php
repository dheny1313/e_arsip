<div class="fixed inset-0 z-50 overflow-y-auto flex flex-col lg:flex-row bg-[#121212] font-sans">

    {{-- SISI KIRI: Branding & Hero Banner (Layar Desktop) --}}
    <div class="relative hidden lg:flex lg:w-3/5 bg-[#121212] overflow-hidden flex-col justify-between p-12 text-white">

        {{-- Background Gradient & Glow Effects --}}
        <div class="absolute inset-0 bg-gradient-to-br from-[#121212] via-[#1e1e1e] to-[#047857]/30 z-0"></div>
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-[#059669]/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-[#FBBF24]/10 rounded-full blur-3xl"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff05_1px,transparent_1px),linear-gradient(to_bottom,#ffffff05_1px,transparent_1px)] bg-[size:24px_24px] z-0"></div>

        {{-- Logo Header --}}
        <div class="relative z-10 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#059669] to-[#047857] flex items-center justify-center shadow-lg shadow-[#059669]/30">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                </svg>
            </div>
            <span class="text-xl font-bold tracking-wider uppercase text-white">E-Arsip Digital</span>
        </div>

        {{-- Pesan Utama --}}
        <div class="relative z-10 my-auto max-w-xl space-y-6">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-[#FBBF24]/10 border border-[#FBBF24]/30 text-[#FBBF24] text-xs font-semibold uppercase tracking-wider">
                <span class="w-2 h-2 rounded-full bg-[#FBBF24] animate-pulse"></span>
                Sistem Manajemen Kearsipan
            </div>

            <h1 class="text-4xl xl:text-5xl font-extrabold tracking-tight leading-tight">
                Kelola Dokumen Instansi Secara <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#059669] via-[#FBBF24] to-[#F59E0B]">Cepat, Aman & Terstruktur.</span>
            </h1>

            <p class="text-gray-300 text-base leading-relaxed">
                Platform kearsipan digital terintegrasi untuk mempermudah pencarian, penyimpanan, dan pendistribusian dokumen secara otomatis.
            </p>

            {{-- Badges Statistik --}}
            <div class="grid grid-cols-3 gap-4 pt-4">
                <div class="p-4 rounded-2xl bg-[#1e1e1e] border border-white/10 backdrop-blur-md">
                    <div class="text-2xl font-bold text-[#059669]">100%</div>
                    <div class="text-xs text-gray-400 mt-1">Aman & Terenkripsi</div>
                </div>
                <div class="p-4 rounded-2xl bg-[#1e1e1e] border border-white/10 backdrop-blur-md">
                    <div class="text-2xl font-bold text-[#FBBF24]">24/7</div>
                    <div class="text-xs text-slate-400 mt-1">Akses Kapan Saja</div>
                </div>
                <div class="p-4 rounded-2xl bg-[#1e1e1e] border border-white/10 backdrop-blur-md">
                    <div class="text-2xl font-bold text-emerald-400">Fast</div>
                    <div class="text-xs text-gray-400 mt-1">Pencarian Cepat</div>
                </div>
            </div>
        </div>

        {{-- Footer Kiri --}}
        <div class="relative z-10 flex justify-between items-center text-xs text-gray-400 border-t border-white/10 pt-6">
            <span>&copy; {{ date('Y') }} E-Arsip System. All rights reserved.</span>
            <span class="text-gray-500">v2.0 Professional</span>
        </div>
    </div>

    {{-- SISI KANAN: Form Login Card --}}
    <div class="flex-1 flex items-center justify-center p-6 sm:p-12 lg:p-16 bg-slate-50 dark:bg-[#121212]">
        <div class="w-full max-w-md space-y-8">

            {{-- Header Mobile --}}
            <div class="lg:hidden text-center space-y-2">
                <div class="inline-flex p-3 rounded-2xl bg-[#059669] text-white shadow-lg shadow-[#059669]/30">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">E-Arsip Digital</h2>
            </div>

            {{-- Judul Form --}}
            <div class="space-y-2">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                    Selamat Datang
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Masukkan <span class="font-semibold text-gray-700 dark:text-gray-200">NIP</span> atau <span class="font-semibold text-gray-700 dark:text-gray-200">Email</span> beserta Kata Sandi Anda.
                </p>
            </div>

            {{-- Card Tempat Form Filament --}}
            <div class="p-8 bg-white dark:bg-[#1e1e1e] rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-white/10 space-y-6">
                <form wire:submit="authenticate" class="space-y-6">
                    {{ $this->form }}

                    <div class="pt-2">
                        <x-filament::button
                            type="submit"
                            size="lg"
                            class="w-full bg-[#059669] hover:bg-[#047857] text-white font-semibold py-3 rounded-xl shadow-lg shadow-[#059669]/25 transition duration-200 transform hover:-translate-y-0.5"
                        >
                            Masuk ke Akun
                        </x-filament::button>
                    </div>
                </form>
            </div>

            {{-- Footer / Bantuan --}}
            <div class="text-center text-xs text-gray-400 dark:text-gray-500">
                <p>Kendala saat masuk? Hubungi <a href="#" class="text-[#059669] dark:text-[#FBBF24] hover:underline font-medium">Administrator Sistem</a></p>
            </div>

        </div>
    </div>

</div>
