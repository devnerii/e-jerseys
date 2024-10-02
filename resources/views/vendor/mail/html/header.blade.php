@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                @php
                    $settings = \Joaopaulolndev\FilamentGeneralSettings\Models\GeneralSetting::first();
                @endphp

                <img src="{{ asset('storage/' . $settings?->site_logo) }}" alt="{{ $settings?->site_name }}"
                    class="h-12" />
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
