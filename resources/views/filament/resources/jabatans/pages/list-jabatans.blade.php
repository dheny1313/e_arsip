<x-filament-panels::page>
    @if ($activeView === 'table')
        {{-- Tampilan Tabel Bawaan Filament --}}
        {{ $this->table }}
    @else
        {{-- Style Khusus Struktur Organisasi (Light & Dark Mode) --}}
        <style>
            .org-wrapper {
                overflow-x: auto;
                padding: 1rem 0.5rem;
            }

            .org-tree, .org-tree * {
                box-sizing: border-box;
            }

            .org-tree ul {
                display: flex !important;
                justify-content: center !important;
                padding-top: 24px !important;
                padding-left: 0 !important;
                margin: 0 !important;
                position: relative;
            }

            .org-tree li {
                float: left;
                text-align: center;
                list-style-type: none !important;
                position: relative;
                padding: 24px 8px 0 8px !important;
                margin: 0 !important;
            }

            /* Garis Pipa Penghubung Bagan */
            .org-tree li::before, .org-tree li::after {
                content: '';
                position: absolute;
                top: 0;
                right: 50%;
                border-top: 2px solid #cbd5e1;
                width: 50%;
                height: 24px;
            }

            .org-tree li::after {
                right: auto;
                left: 50%;
                border-left: 2px solid #cbd5e1;
            }

            .org-tree li:only-child::after, .org-tree li:only-child::before {
                display: none;
            }

            .org-tree li:only-child {
                padding-top: 0 !important;
            }

            .org-tree li:first-child::before, .org-tree li:last-child::after {
                border: 0 none;
            }

            .org-tree li:last-child::before {
                border-right: 2px solid #cbd5e1;
                border-radius: 0 6px 0 0;
            }

            .org-tree li:first-child::after {
                border-radius: 6px 0 0 0;
            }

            .org-tree ul ul::before {
                content: '';
                position: absolute;
                top: 0;
                left: 50%;
                border-left: 2px solid #cbd5e1;
                width: 0;
                height: 24px;
            }

            /* Dark Mode Styling untuk Garis */
            .dark .org-tree li::before,
            .dark .org-tree li::after,
            .dark .org-tree ul ul::before,
            .dark .org-tree li:last-child::before {
                border-color: #475569 !important;
            }

            /* Kartu Node Jabatan */
            .org-card {
                display: inline-flex;
                flex-direction: column;
                width: 210px;
                background-color: #ffffff;
                border: 1px solid #e5e7eb;
                border-radius: 0.75rem;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
                overflow: hidden;
                transition: all 0.2s ease-in-out;
            }

            .org-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                border-color: #3b82f6;
            }

            .dark .org-card {
                background-color: #1f2937;
                border-color: #374151;
            }

            .dark .org-card:hover {
                border-color: #60a5fa;
            }
        </style>

        <x-filament::section>
            <x-slot name="heading">
                <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                    <span class="font-bold text-gray-900 dark:text-white">
                        Bagan Struktur Organisasi
                    </span>
                </div>
            </x-slot>

            <div class="org-wrapper">
                <div class="org-tree text-center min-w-max">
                    <ul>
                        @foreach ($this->getTreeData() as $rootNode)
                            @include('filament.resources.jabatans.partials.tree-node', ['node' => $rootNode])
                        @endforeach
                    </ul>
                </div>
            </div>
        </x-filament::section>
    @endif
</x-filament-panels::page>
