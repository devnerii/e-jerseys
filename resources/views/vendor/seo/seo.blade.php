@php
    $settings = \Joaopaulolndev\FilamentGeneralSettings\Models\GeneralSetting::first();

    if (isset($page) && $page && method_exists($page, 'getSeoModel')) {
        $seo = $page->getSeoModel();
    } elseif (isset($seo) && $seo && is_array($seo) && isset($seo['title'])) {
        $seo = $seo;
    } elseif ($settings !== null) {
        $seo = [
            'title' => $settings->site_name,
            'description' => $settings->site_description,
            'keywords' => $settings->seo_keywords,
            'seo_title' => $settings->seo_title ?? $settings->title,
            'seo_description' => $settings->seo_metadata['og:description'] ?? $settings->site_description,
        ];
    } else {
        $seo = [
            'title' => config('app.name', 'Laravel'),
            'description' => null,
            'keywords' => null,
        ];
    }

    if (!isset($seo['seo_title'])) {
        $seo['seo_title'] = $seo['title'];
    }
    if (!isset($seo['seo_description'])) {
        $seo['seo_description'] = $seo['description'];
    }

    if (!empty($seo['params'])) {
        if (!empty($seo['params']->title_format)) {
            $seo['title'] = str_replace(':text', $seo['title'], $seo['params']->title_format);
        }
    }
    //dd($settings);
@endphp

<title>{{ $seo['title'] }}</title>

@if (config('seo.seo_status'))
    @if (isset($seo['description']) && $seo['description'])
        <meta name="description" content="{{ $seo['description'] }}" />
    @endif

    @if (isset($seo['keywords']) && $seo['keywords'])
        <meta name="keywords" content="{{ $seo['keywords'] }}" />
    @endif

    <meta property="og:title" content="{{ $seo['seo_title'] }}" />
    <meta property="og:description" content="{{ $seo['seo_description'] }}" />
@else
    <meta name="robots"
        content="{{ !empty($seo['follow_type']) && config('seo.seo_status') ? $seo['follow_type'] : 'noindex, nofollow' }}" />
@endif
@if ($settings?->site_favicon)
    <link rel="icon" type="image/png" href="{{ asset('storage/' . $settings->site_favicon) }}">
@endif
<style>
    :root {
        --color-theme-primary: {{ $settings->theme_color ?? '#A6CA64' }};
        --color-theme-primary-darker: {{ hexadj($settings->theme_color ?? '#A6CA64', -75) }};
        --color-theme-primary-lighter: {{ hexadj($settings->theme_color ?? '#A6CA64', 75) }};
        --color-theme-primary-dark: {{ hexadj($settings->theme_color ?? '#A6CA64', -35) }};
        --color-theme-primary-light: {{ hexadj($settings->theme_color ?? '#A6CA64', 35) }};
        --swiper-pagination-color: {{ hexadj($settings->theme_color ?? '#A6CA64', -70) }};
        --swiper-pagination-bullet-width: 14px;
        --swiper-pagination-bullet-height: 14px;

    }
</style>

@if ($settings?->google_analytics_id)
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings->google_analytics_id }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', '{{ $settings->google_analytics_id }}');
    </script>
@endif
@if ($settings?->posthog_html_snippet)
    {{ $settings->posthog_html_snippet }}
@endif
