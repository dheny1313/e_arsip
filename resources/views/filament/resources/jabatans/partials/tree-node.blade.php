<li>
    <div class="org-card">
        {{-- Garis Aksen Warna Atas --}}
        <div style="height: 4px; width: 100%; background-color: #3b82f6;"></div>

        <div style="padding: 0.75rem; display: flex; flex-direction: column; align-items: center; text-align: center;">
            {{-- Icon Jabatan / Avatar --}}
            <div style="width: 32px; height: 32px; border-radius: 9999px; background-color: #eff6ff; display: flex; align-items: center; justify-content: center; margin-bottom: 0.5rem;" class="dark:bg-blue-950/50">
                <x-heroicon-s-briefcase style="width: 18px; height: 18px; color: #2563eb;" />
            </div>

            {{-- Nama Jabatan --}}
            <div style="font-size: 0.8125rem; font-weight: 700; line-height: 1.25; margin-bottom: 0.375rem;" class="text-gray-900 dark:text-gray-100">
                {{ $node->nama_jabatan }}
            </div>

            {{-- Badge Unit Kerja --}}
            <div style="display: inline-flex; align-items: center; padding: 2px 8px; border-radius: 9999px; font-size: 0.6875rem; font-weight: 600; max-width: 100%;" class="bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                <x-heroicon-s-building-office-2 style="width: 12px; height: 12px; margin-right: 4px; color: #9ca3af; flex-shrink: 0;" />
                <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    {{ $node->unitKerja?->nama_unit ?? 'Unit Kerja -' }}
                </span>
            </div>

            {{-- Jumlah Bawahan --}}
            @if ($node->bawahan->count() > 0)
                <div style="display: flex; align-items: center; gap: 4px; font-size: 0.6875rem; font-weight: 500; margin-top: 0.5rem;" class="text-gray-500 dark:text-gray-400">
                    <x-heroicon-s-user-group style="width: 12px; height: 12px; color: #3b82f6; flex-shrink: 0;" />
                    <span>{{ $node->bawahan->count() }} Bawahan</span>
                </div>
            @endif
        </div>

    </div>

    {{-- Render Bawahan Secara Rekursif --}}
    @if ($node->bawahan->count() > 0)
        <ul>
            @foreach ($node->bawahan as $child)
                @include('filament.resources.jabatans.partials.tree-node', ['node' => $child])
            @endforeach
        </ul>
    @endif
</li>
