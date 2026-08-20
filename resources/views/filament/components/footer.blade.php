<div class="mt-8 mb-6 w-full flex justify-center px-4">
    <footer class="relative w-full max-w-7xl overflow-hidden rounded-2xl bg-white/70 dark:bg-[#1e1e1e]/80 backdrop-blur-md border border-slate-200/80 dark:border-white/10 px-6 py-4 transition-all duration-300">

        {{-- Garis Pendar Tipis (Subtle Border Glow) --}}
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-1/3 h-[1px] bg-gradient-to-r from-transparent via-[#059669]/50 dark:via-[#FBBF24]/50 to-transparent"></div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">

            {{-- Kiri: Brand & Versi --}}
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-[#059669] to-[#047857] flex items-center justify-center text-white shadow-sm shadow-[#059669]/20">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                        </svg>
                    </div>
                    <span class="font-bold tracking-wider uppercase text-slate-800 dark:text-gray-200">
                        E-Arsip Digital
                    </span>
                </div>

                <span class="hidden sm:inline text-gray-300 dark:text-gray-700">•</span>

                {{-- Status Badge Kecil --}}
                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#059669]/10 text-[#059669] dark:text-[#FBBF24] text-[11px] font-medium border border-[#059669]/20 dark:border-[#FBBF24]/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#059669] dark:bg-[#FBBF24] animate-pulse"></span>
                    v2.0 Professional
                </div>
            </div>

            {{-- Kanan: Hak Cipta & Link --}}
            <div class="flex items-center gap-4 text-gray-500 dark:text-gray-400 text-[11px]">
                <span>&copy; {{ date('Y') }} E-Arsip Digital Dilmil IV-15 BJM. All rights reserved.</span>
                <span class="text-gray-300 dark:text-gray-700">•</span>
                <a href="#" class="hover:text-[#059669] dark:hover:text-[#FBBF24] transition font-medium">
                    Bantuan
                </a>
            </div>

        </div>

    </footer>
</div>
