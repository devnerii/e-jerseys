@props(['url', 'color' => 'primary', 'align' => 'center'])
@php
    $settings = \Joaopaulolndev\FilamentGeneralSettings\Models\GeneralSetting::first();
@endphp

<table class="action" align="{{ $align }}" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="{{ $align }}">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td align="{{ $align }}">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td>
                                    <a href="{{ $url }}" class="button button-{{ $color }}"
                                        target="_blank" rel="noopener"
                                        style="
    background-color: {{ $settings->theme_color ?? '#A6CA64' }};
    border-bottom: 8px solid {{ $settings->theme_color ?? '#A6CA64' }};
    border-left: 18px solid {{ $settings->theme_color ?? '#A6CA64' }};
    border-right: 18px solid {{ $settings->theme_color ?? '#A6CA64' }};
    border-top: 8px solid {{ $settings->theme_color ?? '#A6CA64' }};
                                        ">{{ $slot }}</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
