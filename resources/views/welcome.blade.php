<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dilmil IV-15 BJM | Solusi Digitalisasi Dokumen Anda</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            black: '#121212',
                            black_light: '#1e1e1e',
                            green: '#059669', /* Emerald 600 */
                            green_dark: '#047857',
                            yellow: '#FBBF24', /* Amber 400 */
                            yellow_hover: '#F59E0B',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Custom CSS untuk Animasi Tambahan -->
    <style>
        /* Efek glassmorphism untuk navbar saat di-scroll */
        .glass-nav {
            background: rgba(18, 18, 18, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Pattern background untuk hero section */
        .hero-pattern {
            background-color: #121212;
            background-image: radial-gradient(#059669 1px, transparent 1px);
            background-size: 40px 40px;
            background-position: center center;
        }

        /* Gradient Text */
        .text-gradient {
            background: linear-gradient(to right, #FBBF24, #10B981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-brand-black overflow-x-hidden">

    <!-- NAVBAR -->
    <nav id="navbar" class="fixed w-full z-50 transition-all duration-300 bg-brand-black text-white py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center gap-2 cursor-pointer">
                    <svg class="w-8 h-8 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                    <span class="font-bold text-2xl tracking-tight">E<span class="text-brand-yellow">-Arsip</span></span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#beranda" class="text-gray-300 hover:text-brand-yellow transition-colors font-medium">Beranda</a>
                    <a href="#fitur" class="text-gray-300 hover:text-brand-yellow transition-colors font-medium">Fitur</a>
                    <a href="#tentang" class="text-gray-300 hover:text-brand-yellow transition-colors font-medium">Keunggulan</a>
                    <!-- Gunakan route() laravel di sini nanti -->
                    <a href="{{ route('filament.admin.auth.login') }}" class="bg-brand-green hover:bg-brand-green_dark text-white px-6 py-2 rounded-full font-semibold transition-all duration-300 shadow-[0_0_15px_rgba(5,150,105,0.4)] hover:shadow-[0_0_25px_rgba(5,150,105,0.6)]">
                        Masuk Sistem
                    </a>
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-gray-300 hover:text-white focus:outline-none">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu (Hidden by default) -->
        <div id="mobile-menu" class="hidden md:hidden bg-brand-black_light border-t border-gray-800">
            <div class="px-4 pt-2 pb-6 space-y-2 text-center shadow-2xl">
                <a href="#beranda" class="block px-3 py-3 text-gray-300 hover:text-brand-yellow hover:bg-gray-800 rounded-md font-medium">Beranda</a>
                <a href="#fitur" class="block px-3 py-3 text-gray-300 hover:text-brand-yellow hover:bg-gray-800 rounded-md font-medium">Fitur</a>
                <a href="#tentang" class="block px-3 py-3 text-gray-300 hover:text-brand-yellow hover:bg-gray-800 rounded-md font-medium">Keunggulan</a>
                <a href="{{ route('filament.admin.auth.login') }}" class="block w-full mt-4 bg-brand-green text-white px-6 py-3 rounded-full font-semibold">Masuk Sistem</a>
            </div>
        </div>
    </nav>

    <!-- HEADER / HERO SECTION -->
    <header id="beranda" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-brand-black text-white">
        <!-- Overlay Gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-brand-black via-brand-black to-brand-green_dark opacity-90 z-0"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-brand-green/20 border border-brand-green/50 text-brand-green font-semibold text-sm mb-6 tracking-wide uppercase">
                Era Baru Manajemen Dokumen
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-7xl font-extrabold tracking-tight mb-6 leading-tight">
                Tinggalkan Kertas, <br>
                <span class="text-gradient">Beralih ke Digital.</span>
            </h1>
            <p class="mt-4 text-lg md:text-xl text-gray-400 max-w-3xl mx-auto mb-10 leading-relaxed">
                Simpan, kelola, dan temukan dokumen penting perusahaan Anda dalam hitungan detik. Keamanan tingkat tinggi, akses mudah dari mana saja, kapan saja.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#mulai" class="bg-brand-yellow hover:bg-brand-yellow_hover text-brand-black px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 transform hover:-translate-y-1 hover:shadow-[0_10px_40px_-10px_rgba(251,191,36,0.7)] flex items-center justify-center gap-2">
                    Mulai Digitalisasi
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
                <a href="#fitur" class="bg-transparent border-2 border-gray-600 hover:border-brand-green text-white px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 flex items-center justify-center">
                    Pelajari Fitur
                </a>
            </div>
        </div>

        <!-- Decorative Shape Bottom -->
        <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-none z-10">
            <svg class="relative block w-full h-[50px] md:h-[100px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118.08,130.83,119.93,191.36,97.66,242.43,78.85,284.57,64.21,321.39,56.44Z" fill="#f9fafb"></path>
            </svg>
        </div>
    </header>

    <!-- FITUR / LAYANAN UTAMA SECTION -->
    <section id="fitur" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-brand-green font-bold tracking-wide uppercase text-sm mb-2">Mengapa Memilih Kami?</h2>
                <h3 class="text-3xl md:text-4xl font-extrabold text-brand-black mb-4">Semua yang Anda Butuhkan untuk Manajemen Arsip</h3>
                <p class="text-gray-600 text-lg">Sistem E-Arsip dirancang khusus untuk mempercepat alur kerja dan melindungi aset informasi berharga Anda.</p>
            </div>

            <!-- Grid Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

                <!-- Card 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:border-brand-green group cursor-pointer">
                    <div class="w-14 h-14 bg-brand-green/10 rounded-xl flex items-center justify-center mb-6 group-hover:bg-brand-green transition-colors duration-300">
                        <svg class="w-7 h-7 text-brand-green group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-brand-black mb-3">Keamanan Tingkat Tinggi</h4>
                    <p class="text-gray-500 leading-relaxed">Arsip Anda dilindungi dengan enkripsi mutakhir dan backup otomatis. Bebas dari risiko hilang atau rusak.</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:border-brand-yellow group cursor-pointer">
                    <div class="w-14 h-14 bg-brand-yellow/10 rounded-xl flex items-center justify-center mb-6 group-hover:bg-brand-yellow transition-colors duration-300">
                        <svg class="w-7 h-7 text-brand-yellow group-hover:text-brand-black transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-brand-black mb-3">Pencarian Instan</h4>
                    <p class="text-gray-500 leading-relaxed">Fitur smart search memungkinkan Anda menemukan dokumen spesifik dari ribuan arsip hanya dalam hitungan detik.</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:border-brand-green group cursor-pointer">
                    <div class="w-14 h-14 bg-brand-green/10 rounded-xl flex items-center justify-center mb-6 group-hover:bg-brand-green transition-colors duration-300">
                        <svg class="w-7 h-7 text-brand-green group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-brand-black mb-3">Akses Cloud 24/7</h4>
                    <p class="text-gray-500 leading-relaxed">Tidak terikat meja kerja. Akses, setujui, dan bagikan dokumen kapan saja, dari perangkat apapun.</p>
                </div>

                <!-- Card 4 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:border-brand-yellow group cursor-pointer">
                    <div class="w-14 h-14 bg-brand-yellow/10 rounded-xl flex items-center justify-center mb-6 group-hover:bg-brand-yellow transition-colors duration-300">
                        <svg class="w-7 h-7 text-brand-yellow group-hover:text-brand-black transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-brand-black mb-3">Paperless & Efisien</h4>
                    <p class="text-gray-500 leading-relaxed">Kurangi penggunaan kertas dan ruang penyimpanan fisik. Hemat biaya operasional dan selamatkan lingkungan.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- CALL TO ACTION (CTA) SECTION -->
    <section class="py-20 bg-brand-green text-white relative overflow-hidden">
        <!-- Abstract Circles -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-brand-green_dark opacity-50 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-brand-yellow opacity-20 blur-3xl"></div>

        <div class="relative z-10 max-w-5xl mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-5xl font-bold mb-6">Siap Mengamankan Arsip Perusahaan Anda?</h2>
            <p class="text-brand-green_dark text-white/80 text-xl mb-10 max-w-2xl mx-auto">Bergabunglah dengan ratusan perusahaan lain yang telah mendigitalisasi proses kerja mereka menjadi lebih efisien dan terorganisir.</p>
            <a href="#" class="inline-block bg-brand-black hover:bg-gray-800 text-brand-yellow px-10 py-4 rounded-full font-bold text-lg shadow-2xl transition-all transform hover:-translate-y-1">
                Buat Akun Gratis Sekarang
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-brand-black text-gray-400 py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Brand Info -->
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-6 h-6 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                        <span class="font-bold text-xl text-white tracking-tight">E<span class="text-brand-yellow">-Arsip</span></span>
                    </div>
                    <p class="text-sm max-w-md">Platform solusi cerdas untuk menyimpan, mengelola, dan mendistribusikan arsip secara digital dengan tingkat keamanan paripurna.</p>
                </div>

                <!-- Tautan Cepat -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#beranda" class="hover:text-brand-yellow transition-colors">Beranda</a></li>
                        <li><a href="#fitur" class="hover:text-brand-yellow transition-colors">Fitur Kami</a></li>
                        <li><a href="#" class="hover:text-brand-yellow transition-colors">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-brand-yellow transition-colors">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Hubungi Kami</h4>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            hello@earsip.com
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            +62 811 2345 6789
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm">
                <p>&copy; {{ date('Y') }} Sistem E-Arsip Dilmil IV-15 BJM. Hak Cipta Dilindungi.</p>
                <div class="flex gap-4 mt-4 md:mt-0">
                    <!-- Social icons dummy -->
                    <a href="#" class="text-gray-500 hover:text-brand-yellow transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                    <a href="#" class="text-gray-500 hover:text-brand-yellow transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JAVASCRIPT UNTUK INTERAKSI MENU & SCROLL -->
    <script>
        // Toggle Mobile Menu
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const icon = document.getElementById('menu-icon');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
            // Ganti icon hamburger ke "X"
            if(menu.classList.contains('hidden')){
                icon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
            } else {
                icon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
            }
        });

        // Efek Glassmorphism Navbar saat Scroll
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('glass-nav');
                nav.classList.remove('bg-brand-black');
            } else {
                nav.classList.remove('glass-nav');
                nav.classList.add('bg-brand-black');
            }
        });
    </script>

</body>
</html>
