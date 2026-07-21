<x-filament-panels::page>

    {{-- 1. SAKELAR / TAB FILAMENT V3 --}}
    @if (count($tabs = $this->getTabs()))
        <x-filament::tabs>
            @foreach ($tabs as $tabKey => $tab)
                <x-filament::tabs.item
                    :active="$activeTab === $tabKey"
                    :badge="$tab->getBadge()"
                    :badge-color="$tab->getBadgeColor()"
                    :icon="$tab->getIcon()"
                    wire:click="$set('activeTab', '{{ $tabKey }}')"
                >
                    {{ $tab->getLabel() }}
                </x-filament::tabs.item>
            @endforeach
        </x-filament::tabs>
    @endif

    {{-- 2. TAMPILAN FOLDER BROWSER --}}
    @include('filament.arsip-folder-browser')

    {{-- 3. TABEL DATA ARSIP --}}
    {{ $this->table }}

</x-filament-panels::page>
