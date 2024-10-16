<?php

use Joaopaulolndev\FilamentGeneralSettings\Enums\TypeFieldEnum;

return [
    'show_application_tab' => true,
    'show_logo_and_favicon' => true,
    'show_analytics_tab' => true,
    'show_seo_tab' => true,
    'show_email_tab' => false,
    'show_social_networks_tab' => true,
    'expiration_cache_config_time' => 60,
    'show_custom_tabs' => true,
    'custom_tabs' => [
        'more_configs' => [
            'label' => 'Header and Footer',
            'icon' => 'heroicon-o-view-columns',
            'columns' => 1,
            'fields' => [
                'alert_text' => [
                    'type' => TypeFieldEnum::Text->value,
                    'label' => 'Alert Text',
                    'placeholder' => 'Enter the alert text',
                    'required' => false,
                    'rules' => 'required|string|max:255',
                ],
                'rodape_1_titulo' => [
                    'type' => TypeFieldEnum::Text->value,
                    'label' => 'Footer Title (Column 1)',
                    'placeholder' => 'Enter the footer title (Column 1)',
                    'required' => false,
                    'rules' => 'required|string|max:255',
                ],
                'rodape_1' => [
                    'type' => TypeFieldEnum::Textarea->value,
                    'label' => 'Footer (Column 1)',
                    'placeholder' => 'Enter the footer text (Column 1)',
                    'required' => false,
                    'rows' => '5',
                ],
                'rodape_2_titulo' => [
                    'type' => TypeFieldEnum::Text->value,
                    'label' => 'Footer Title (Column 2)',
                    'placeholder' => 'Enter the footer title (Column 2)',
                    'required' => false,
                    'rules' => 'required|string|max:255',
                ],
                'rodape_2' => [
                    'type' => TypeFieldEnum::Textarea->value,
                    'label' => 'Footer (Column 2)',
                    'placeholder' => 'Enter the footer text (Column 2)',
                    'required' => false,
                    'rows' => '5',
                ],
                'rodape_3_titulo' => [
                    'type' => TypeFieldEnum::Text->value,
                    'label' => 'Footer Title (Column 3)',
                    'placeholder' => 'Enter the footer title (Column 3)',
                    'required' => false,
                    'rules' => 'required|string|max:255',
                ],
                'rodape_3' => [
                    'type' => TypeFieldEnum::Textarea->value,
                    'label' => 'Footer (Column 3)',
                    'placeholder' => 'Enter the footer text (Column 3)',
                    'required' => false,
                    'rows' => '5',
                ],
            ],
        ],
        'payment' => [
            'label' => 'Payment Method',
            'icon' => 'heroicon-o-banknotes',
            'columns' => 2,
            'fields' => [
                'stripe_public_key' => [
                    'type' => TypeFieldEnum::Text->value,
                    'label' => 'Publishable Key',
                    'placeholder' => 'Publishable Key',
                    'required' => false,
                    'rules' => 'required|string|max:255',
                ],
                'stripe_private_key' => [
                    'type' => TypeFieldEnum::Text->value,
                    'label' => 'Secret Key',
                    'placeholder' => 'Secret Key',
                    'required' => false,
                    'rules' => 'required|string|max:255',
                ],
                'stripe_webhook_secret_key' => [
                    'type' => TypeFieldEnum::Text->value,
                    'label' => 'Webhook Secret Key',
                    'placeholder' => 'Webhook Secret Key',
                    'required' => false,
                    'rules' => 'required|string|max:255',
                    'span' => 2,
                ],
            ],
        ],
    ],
];
