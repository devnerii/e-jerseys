@php
    $settings = \Joaopaulolndev\FilamentGeneralSettings\Models\GeneralSetting::first();
    $menu_footer_1 = App\Models\Menu::with('homepage')->where('is_active', true)->where('section', 'footer_1')->where('home_page_id', $homePage->id)->get()->toArray();
    foreach ($menu_footer_1 as $key => $menu) {
        if ($menu_footer_1[$key]['link_type'] == 'external' || $menu_footer_1[$key]['link_type'] == 'none') {
            $menu_footer_1[$key]['link'] = $menu_footer_1[$key]['link_slug'];
        } else {
            $menu_footer_1[$key]['link'] = route('site.' . $menu_footer_1[$key]['link_type'], [
                'slug' => $menu_footer_1[$key]['link_slug'],
                'homePageSlug' => $menu_footer_1[$key]['homepage']['slug']
            ]);
        }
    }
    $menu_footer_2 = App\Models\Menu::with('homepage')->where('is_active', true)->where('section', 'footer_2')->where('home_page_id', $homePage->id)->get()->toArray();
    foreach ($menu_footer_2 as $key => $menu) {
        if ($menu_footer_2[$key]['link_type'] == 'external' || $menu_footer_2[$key]['link_type'] == 'none') {
            $menu_footer_2[$key]['link'] = $menu_footer_2[$key]['link_slug'];
        } else {
            $menu_footer_2[$key]['link'] = route('site.' . $menu_footer_2[$key]['link_type'], [
                'slug' => $menu_footer_2[$key]['link_slug'],
                'homePageSlug' => $menu_footer_2[$key]['homepage']['slug']
            ]);
        }
    }
    $menu_footer_3 = App\Models\Menu::with('homepage')->where('is_active', true)->where('section', 'footer_3')->where('home_page_id', $homePage->id)->get()->toArray();
    foreach ($menu_footer_3 as $key => $menu) {
        if ($menu_footer_3[$key]['link_type'] == 'external' || $menu_footer_3[$key]['link_type'] == 'none') {
            $menu_footer_3[$key]['link'] = $menu_footer_3[$key]['link_slug'];
        } else {
            $menu_footer_3[$key]['link'] = route('site.' . $menu_footer_3[$key]['link_type'], [
                'slug' => $menu_footer_3[$key]['link_slug'],
                'homePageSlug' => $menu_footer_3[$key]['homepage']['slug']
            ]);
        }
    }
@endphp
<footer class="w-full py-8 font-medium text-white bg-primary-dark text-primary-lighter">
    <div class="px-2 mx-auto max-w-7xl md:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div>
                <h2 class="text-sm font-semibold">
                    {{ isset($settings['more_configs']['rodape_1_titulo']) ? $settings['more_configs']['rodape_1_titulo'] : '' }}
                </h2>
                <span class="text-xs">{!! isset($settings['more_configs']['rodape_1']) ? $settings['more_configs']['rodape_1'] : '' !!}</span>
                <div class="flex flex-col gap-3 mt-4">
                    @for ($i = 0; $i < count($menu_footer_1); $i++)
                        <a class="text-xs font-medium text-white transition-colors hover:text-primary hover:underline"
                            href="{{ $menu_footer_1[$i]['link'] }}"
                            @if ($menu_footer_1[$i]['link_type'] == 'external') target="_blank" rel="noreferrer nofollow" @endif>{{ $menu_footer_1[$i]['label'] }}</a>
                    @endfor
                </div>
            </div>
            <div>
                <h2 class="text-sm font-semibold">
                    {{ isset($settings['more_configs']['rodape_2_titulo']) ? $settings['more_configs']['rodape_2_titulo'] : '' }}
                </h2>
                <span class="text-xs">{!! isset($settings['more_configs']['rodape_2']) ? $settings['more_configs']['rodape_2'] : '' !!}</span>
                <div class="flex flex-col gap-3 mt-4">
                    @for ($i = 0; $i < count($menu_footer_2); $i++)
                        <a class="text-xs font-medium text-white transition-colors hover:text-primary hover:underline"
                            href="{{ $menu_footer_2[$i]['link'] }}"
                            @if ($menu_footer_2[$i]['link_type'] == 'external') target="_blank" rel="noreferrer nofollow" @endif>{{ $menu_footer_2[$i]['label'] }}</a>
                    @endfor
                </div>
            </div>
            <div>
                <h2 class="text-sm font-semibold">
                    {{ isset($settings['more_configs']['rodape_3_titulo']) ? $settings['more_configs']['rodape_3_titulo'] : '' }}
                </h2>
                <span class="text-xs">{!! isset($settings['more_configs']['rodape_3']) ? $settings['more_configs']['rodape_3'] : '' !!}</span>
                <div class="flex flex-col gap-3 mt-4">
                    @for ($i = 0; $i < count($menu_footer_3); $i++)
                        <a class="text-xs font-medium text-white transition-colors hover:text-primary hover:underline"
                            href="{{ $menu_footer_3[$i]['link'] }}"
                            @if ($menu_footer_3[$i]['link_type'] == 'external') target="_blank" rel="noreferrer nofollow" @endif>{{ $menu_footer_3[$i]['label'] }}</a>
                    @endfor
                </div>
            </div>
        </div>
    </div>
    <div class="px-2 mx-auto my-16 max-w-7xl md:px-6 lg:px-8">
        <div class="flex justify-center gap-2">
            @if (isset($settings['social_network']['whatsapp']))
                <a href="https://wa.me/{{ $settings['social_network']['whatsapp'] }}" target="_blank"
                    rel="nofollow noreferrer" class="w-6 h-6">
                    {{-- Whatsapp --}}
                    <svg width="800px" height="800px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                        class="w-full h-full transition-colors stroke-none fill-white hover:fill-primary">
                        <path
                            d="M17.6 6.31999C16.8669 5.58141 15.9943 4.99596 15.033 4.59767C14.0716 4.19938 13.0406 3.99622 12 3.99999C10.6089 4.00135 9.24248 4.36819 8.03771 5.06377C6.83294 5.75935 5.83208 6.75926 5.13534 7.96335C4.4386 9.16745 4.07046 10.5335 4.06776 11.9246C4.06507 13.3158 4.42793 14.6832 5.12 15.89L4 20L8.2 18.9C9.35975 19.5452 10.6629 19.8891 11.99 19.9C14.0997 19.9001 16.124 19.0668 17.6222 17.5816C19.1205 16.0965 19.9715 14.0796 19.99 11.97C19.983 10.9173 19.7682 9.87634 19.3581 8.9068C18.948 7.93725 18.3505 7.05819 17.6 6.31999ZM12 18.53C10.8177 18.5308 9.65701 18.213 8.64 17.61L8.4 17.46L5.91 18.12L6.57 15.69L6.41 15.44C5.55925 14.0667 5.24174 12.429 5.51762 10.8372C5.7935 9.24545 6.64361 7.81015 7.9069 6.80322C9.1702 5.79628 10.7589 5.28765 12.3721 5.37368C13.9853 5.4597 15.511 6.13441 16.66 7.26999C17.916 8.49818 18.635 10.1735 18.66 11.93C18.6442 13.6859 17.9355 15.3645 16.6882 16.6006C15.441 17.8366 13.756 18.5301 12 18.53ZM15.61 13.59C15.41 13.49 14.44 13.01 14.26 12.95C14.08 12.89 13.94 12.85 13.81 13.05C13.6144 13.3181 13.404 13.5751 13.18 13.82C13.07 13.96 12.95 13.97 12.75 13.82C11.6097 13.3694 10.6597 12.5394 10.06 11.47C9.85 11.12 10.26 11.14 10.64 10.39C10.6681 10.3359 10.6827 10.2759 10.6827 10.215C10.6827 10.1541 10.6681 10.0941 10.64 10.04C10.64 9.93999 10.19 8.95999 10.03 8.56999C9.87 8.17999 9.71 8.23999 9.58 8.22999H9.19C9.08895 8.23154 8.9894 8.25465 8.898 8.29776C8.8066 8.34087 8.72546 8.403 8.66 8.47999C8.43562 8.69817 8.26061 8.96191 8.14676 9.25343C8.03291 9.54495 7.98287 9.85749 8 10.17C8.0627 10.9181 8.34443 11.6311 8.81 12.22C9.6622 13.4958 10.8301 14.5293 12.2 15.22C12.9185 15.6394 13.7535 15.8148 14.58 15.72C14.8552 15.6654 15.1159 15.5535 15.345 15.3915C15.5742 15.2296 15.7667 15.0212 15.91 14.78C16.0428 14.4856 16.0846 14.1583 16.03 13.84C15.94 13.74 15.81 13.69 15.61 13.59Z" />
                    </svg>
                </a>
            @endif

            @if (isset($settings['social_network']['facebook']))
                <a href="https://www.facebook.com/{{ $settings['social_network']['facebook'] }}" target="_blank"
                    rel="nofollow noreferrer" class="w-6 h-6">
                    {{-- Facebook --}}
                    <svg width="800px" height="800px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                        class="w-full h-full transition-colors stroke-none fill-white hover:fill-primary">
                        <path
                            d="M12 2.03998C6.5 2.03998 2 6.52998 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.84998C10.44 7.33998 11.93 5.95998 14.22 5.95998C15.31 5.95998 16.45 6.14998 16.45 6.14998V8.61998H15.19C13.95 8.61998 13.56 9.38998 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96C15.9164 21.5878 18.0622 20.3855 19.6099 18.57C21.1576 16.7546 22.0054 14.4456 22 12.06C22 6.52998 17.5 2.03998 12 2.03998Z" />
                    </svg>
                </a>
            @endif

            @if (isset($settings['social_network']['instagram']))
                <a href="https://www.instagram.com/{{ $settings['social_network']['instagram'] }}" target="_blank"
                    rel="nofollow noreferrer" class="w-6 h-6">
                    {{-- Instagram --}}
                    <svg width="800px" height="800px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                        class="w-full h-full transition-colors stroke-none fill-white hover:fill-primary">
                        <g id="Page-1" stroke="none" stroke-width="1" fill-rule="evenodd">
                            <g id="Dribbble-Light-Preview" transform="translate(-340.000000, -7439.000000)">
                                <g id="icons" transform="translate(56.000000, 160.000000)">
                                    <path
                                        d="M289.869652,7279.12273 C288.241769,7279.19618 286.830805,7279.5942 285.691486,7280.72871 C284.548187,7281.86918 284.155147,7283.28558 284.081514,7284.89653 C284.035742,7285.90201 283.768077,7293.49818 284.544207,7295.49028 C285.067597,7296.83422 286.098457,7297.86749 287.454694,7298.39256 C288.087538,7298.63872 288.809936,7298.80547 289.869652,7298.85411 C298.730467,7299.25511 302.015089,7299.03674 303.400182,7295.49028 C303.645956,7294.859 303.815113,7294.1374 303.86188,7293.08031 C304.26686,7284.19677 303.796207,7282.27117 302.251908,7280.72871 C301.027016,7279.50685 299.5862,7278.67508 289.869652,7279.12273 M289.951245,7297.06748 C288.981083,7297.0238 288.454707,7296.86201 288.103459,7296.72603 C287.219865,7296.3826 286.556174,7295.72155 286.214876,7294.84312 C285.623823,7293.32944 285.819846,7286.14023 285.872583,7284.97693 C285.924325,7283.83745 286.155174,7282.79624 286.959165,7281.99226 C287.954203,7280.99968 289.239792,7280.51332 297.993144,7280.90837 C299.135448,7280.95998 300.179243,7281.19026 300.985224,7281.99226 C301.980262,7282.98483 302.473801,7284.28014 302.071806,7292.99991 C302.028024,7293.96767 301.865833,7294.49274 301.729513,7294.84312 C300.829003,7297.15085 298.757333,7297.47145 289.951245,7297.06748 M298.089663,7283.68956 C298.089663,7284.34665 298.623998,7284.88065 299.283709,7284.88065 C299.943419,7284.88065 300.47875,7284.34665 300.47875,7283.68956 C300.47875,7283.03248 299.943419,7282.49847 299.283709,7282.49847 C298.623998,7282.49847 298.089663,7283.03248 298.089663,7283.68956 M288.862673,7288.98792 C288.862673,7291.80286 291.150266,7294.08479 293.972194,7294.08479 C296.794123,7294.08479 299.081716,7291.80286 299.081716,7288.98792 C299.081716,7286.17298 296.794123,7283.89205 293.972194,7283.89205 C291.150266,7283.89205 288.862673,7286.17298 288.862673,7288.98792 M290.655732,7288.98792 C290.655732,7287.16159 292.140329,7285.67967 293.972194,7285.67967 C295.80406,7285.67967 297.288657,7287.16159 297.288657,7288.98792 C297.288657,7290.81525 295.80406,7292.29716 293.972194,7292.29716 C292.140329,7292.29716 290.655732,7290.81525 290.655732,7288.98792"
                                        id="instagram-[#167]">

                                    </path>
                                </g>
                            </g>
                        </g>
                    </svg>
                </a>
            @endif

            @if (isset($settings['social_network']['x_twitter']))
                <a href="https://x.com/{{ $settings['social_network']['x_twitter'] }}" class="w-6 h-6" target="_blank"
                    rel="nofollow noreferrer">
                    {{-- Twitter / X --}}
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100"
                        viewBox="0 0 50 50"
                        class="w-full h-full transition-colors stroke-none fill-white hover:fill-primary">
                        <path
                            d="M 11 4 C 7.134 4 4 7.134 4 11 L 4 39 C 4 42.866 7.134 46 11 46 L 39 46 C 42.866 46 46 42.866 46 39 L 46 11 C 46 7.134 42.866 4 39 4 L 11 4 z M 13.085938 13 L 21.023438 13 L 26.660156 21.009766 L 33.5 13 L 36 13 L 27.789062 22.613281 L 37.914062 37 L 29.978516 37 L 23.4375 27.707031 L 15.5 37 L 13 37 L 22.308594 26.103516 L 13.085938 13 z M 16.914062 15 L 31.021484 35 L 34.085938 35 L 19.978516 15 L 16.914062 15 z">
                        </path>
                    </svg>
                </a>
            @endif

            @if (isset($settings['social_network']['youtube']))
                <a href="https://www.youtube.com/{{ $settings['social_network']['youtube'] }}" class="w-6 h-6"
                    target="_blank" rel="nofollow noreferrer">
                    {{-- Youtube --}}
                    <svg fill="#000000" height="800px" width="800px" version="1.1" id="XMLID_3_"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        class="w-full h-full transition-colors stroke-none fill-white hover:fill-primary">

                        <path d="M23.7,7.4c0,0-0.3-1.5-0.9-2.3c-0.9-0.9-2-0.8-2.4-0.9C17.1,4,12,4,12,4l0,0c0,0-5.1,0-8.4,0.2c-0.4,0.1-1.5,0.1-2.4,1
                               C0.5,5.9,0.3,7.5,0.3,7.5S0,9.4,0,11.2v1.7c0,1.9,0.3,3.7,0.3,3.7s0.3,1.5,0.9,2.3c0.9,0.9,2.1,0.8,2.7,0.9C5.7,20,12,20,12,20
                               s5.1,0,8.4-0.2c0.4-0.1,1.5-0.1,2.4-1c0.7-0.7,0.9-2.3,0.9-2.3s0.3-1.9,0.3-3.6v-1.7C24,9.3,23.7,7.4,23.7,7.4z M9.3,15.1V8.4
                               l6.9,3.4L9.3,15.1z" />

                    </svg>
                </a>
            @endif

            @if (isset($settings['social_network']['linkedin']))
                <a href="https://www.linkedin.com/in/{{ $settings['social_network']['linkedin'] }}" class="w-6 h-6"
                    target="_blank" rel="nofollow noreferrer">
                    {{-- Linkedin --}}
                    <svg width="800px" height="800px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                        class="w-full h-full transition-colors stroke-none fill-white hover:fill-primary">
                        <path
                            d="M19,3a2,2,0,0,1,2,2V19a2,2,0,0,1-2,2H5a2,2,0,0,1-2-2V5A2,2,0,0,1,5,3H19m-.5,15.5V13.2a3.26,3.26,0,0,0-3.26-3.26h0a2.9,2.9,0,0,0-2.32,1.3V10.13H10.13V18.5h2.79V13.57a1.4,1.4,0,1,1,2.79,0V18.5H18.5M6.88,8.56A1.68,1.68,0,0,0,8.56,6.88h0a1.69,1.69,0,1,0-3.37,0h0A1.69,1.69,0,0,0,6.88,8.56M8.27,18.5V10.13H5.5V18.5Z" />
                    </svg>
                </a>
            @endif

            @if (isset($settings['social_network']['tiktok']))
                <a href="https://www.tiktok.com/{{ $settings['social_network']['tiktok'] }}" class="w-6 h-6"
                    target="_blank" rel="nofollow noreferrer">
                    {{-- Tiktok --}}
                    <svg width="800px" height="800px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                        class="w-full h-full transition-colors stroke-none fill-white hover:fill-primary">
                        <path
                            d="M16.8218 5.1344C16.0887 4.29394 15.648 3.19805 15.648 2H14.7293C14.9659 3.3095 15.7454 4.43326 16.8218 5.1344Z" />
                        <path
                            d="M8.3218 11.9048C6.73038 11.9048 5.43591 13.2004 5.43591 14.7931C5.43591 15.903 6.06691 16.8688 6.98556 17.3517C6.64223 16.8781 6.43808 16.2977 6.43808 15.6661C6.43808 14.0734 7.73255 12.7778 9.324 12.7778C9.62093 12.7778 9.90856 12.8288 10.1777 12.9124V9.40192C9.89927 9.36473 9.61628 9.34149 9.324 9.34149C9.27294 9.34149 9.22654 9.34614 9.1755 9.34614V12.0394C8.90176 11.9558 8.61873 11.9048 8.3218 11.9048Z" />
                        <path
                            d="M19.4245 6.67608V9.34614C17.6429 9.34614 15.9912 8.77501 14.6456 7.80911V14.7977C14.6456 18.2851 11.8108 21.127 8.32172 21.127C6.97621 21.127 5.7235 20.6998 4.69812 19.98C5.8534 21.2198 7.50049 22 9.32392 22C12.8083 22 15.6478 19.1627 15.6478 15.6707V8.68211C16.9933 9.64801 18.645 10.2191 20.4267 10.2191V6.78293C20.0787 6.78293 19.7446 6.74574 19.4245 6.67608Z" />
                        <path
                            d="M14.6456 14.7977V7.80911C15.9912 8.77501 17.6429 9.34614 19.4245 9.34614V6.67608C18.3945 6.45788 17.4899 5.90063 16.8218 5.1344C15.7454 4.43326 14.9704 3.3095 14.7245 2H12.2098L12.2051 15.7775C12.1495 17.3192 10.8782 18.5591 9.32393 18.5591C8.35884 18.5591 7.50977 18.0808 6.98085 17.3564C6.06219 16.8688 5.4312 15.9076 5.4312 14.7977C5.4312 13.205 6.72567 11.9094 8.31708 11.9094C8.61402 11.9094 8.90168 11.9605 9.17079 12.0441V9.35079C5.75598 9.42509 3 12.2298 3 15.6707C3 17.3331 3.64492 18.847 4.69812 19.98C5.7235 20.6998 6.97621 21.127 8.32172 21.127C11.8061 21.127 14.6456 18.2851 14.6456 14.7977Z" />
                    </svg>
                </a>
            @endif

            @if (isset($settings['social_network']['pinterest']))
                <a href="https://br.pinterest.com/{{ $settings['social_network']['pinterest'] }}" class="w-6 h-6"
                    target="_blank" rel="nofollow noreferrer">
                    {{-- Pinterest --}}
                    <svg width="800px" height="800px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                        class="w-full h-full transition-colors stroke-none fill-white hover:fill-primary">
                        <g id="Page-1" stroke="none" stroke-width="1">
                            <g id="Dribbble-Light-Preview" transform="translate(-220.000000, -7399.000000)">
                                <g transform="translate(56.000000, 160.000000)">
                                    <path
                                        d="M173.876,7239 C168.399,7239 164,7243.43481 164,7248.95866 C164,7253.05869 166.407,7256.48916 169.893,7258.07936 C169.893,7256.21186 169.88,7256.45286 171.303,7250.38046 C170.521,7248.80236 171.129,7246.19673 172.88,7246.19673 C175.31,7246.19673 173.659,7249.79964 173.378,7251.2174 C173.129,7252.30544 173.959,7253.14238 174.955,7253.14238 C176.864,7253.14238 178.108,7250.71524 178.108,7247.87063 C178.108,7245.69456 176.615,7244.10437 174.042,7244.10437 C169.467,7244.10437 168.307,7249.19966 169.893,7250.79893 C170.292,7251.40294 169.893,7251.43118 169.893,7252.22174 C169.616,7253.05768 167.403,7251.84259 167.403,7248.70757 C167.403,7245.86195 169.727,7242.51518 174.457,7242.51518 C178.191,7242.51518 180.681,7245.27609 180.681,7248.2054 C180.681,7252.13805 178.523,7254.98366 175.37,7254.98366 C174.291,7254.98366 173.295,7254.3978 172.963,7253.72824 C172.36,7256.07371 172.238,7257.26258 171.303,7258.58153 C172.216,7258.83261 173.129,7259 174.125,7259 C179.602,7259 184,7254.56519 184,7249.04235 C183.752,7243.43481 179.353,7239 173.876,7239">

                                    </path>
                                </g>
                            </g>
                        </g>
                    </svg>
                </a>
            @endif
        </div>
    </div>
    <div class="px-2 mx-auto text-xs text-center max-w-7xl md:px-3">
        © 2024, {{ $settings?->site_name }}
    </div>
</footer>
