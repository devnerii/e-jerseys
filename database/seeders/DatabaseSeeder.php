<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Address;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Seeder;
use Joaopaulolndev\FilamentGeneralSettings\Models\GeneralSetting;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Jimmy Stelzer',
            'email' => 'jimmy.stelzer@jit-tecnologia.com.br',
            'password' => '123456',
            'is_admin' => true,
        ]);
        User::factory()->create([
            'name' => 'Matheus Admin',
            'email' => 'matheus@teste.com',
            'password' => bcrypt('1234'),
            'is_admin' => true,
        ]);
        User::factory()->create([
            'name' => 'Kelly Stelzer',
            'email' => 'kelly@kaor.com.br',
            'password' => '$2y$12$KdvlQjLgFW1q.PdtnY0RMu5LXPNX9SkuoI0Y1pzHVjwOvkYUK.CJ2',
            'is_admin' => false,
        ]);

        GeneralSetting::create(
            [
                'site_name' => 'SunKids',
                'site_description' => 'Celebre o aniversário da SunKids com DESCONTOS IMPERDÍVEIS! Leve 3 óculos infantis flexíveis por apenas R$39,90 cada. Corra e aproveite!',
                'site_logo' => 'assets/site_logo.webp',
                'site_favicon' => 'assets/site_favicon.ico',
                'theme_color' => '#a6ca64',
                'support_email' => 'jimmy.stelzer@jit-tecnologia.com.br',
                'support_phone' => '(11) 9 9999-9999',
                'google_analytics_id' => 'UA-123456789-0',
                'posthog_html_snippet' => '',
                'seo_title' => 'SunKids',
                'seo_keywords' => 'SunKids,óculos,infantis',
                'seo_metadata' => json_decode('{"twitter:title":"SunKids","twitter:description":"Celebre o anivers\u00e1rio da SunKids com DESCONTOS IMPERD\u00cdVEIS! Leve 3 \u00f3culos infantis flex\u00edveis por apenas R$39,90 cada. Corra e aproveite!","og:url":"https:\/\/jit-shop.ddev.site\/","og:description":"Celebre o anivers\u00e1rio da SunKids com DESCONTOS IMPERD\u00cdVEIS! Leve 3 \u00f3culos infantis flex\u00edveis por apenas R$39,90 cada. Corra e aproveite!"}'),
                'email_settings' => json_decode('{"default_email_provider":"smtp","smtp_host":null,"smtp_port":null,"smtp_encryption":null,"smtp_timeout":null,"smtp_username":null,"smtp_password":null,"mailgun_domain":null,"mailgun_secret":null,"mailgun_endpoint":null,"postmark_token":null,"amazon_ses_key":null,"amazon_ses_secret":null,"amazon_ses_region":null}'),
                'email_from_address' => 'jimmy.stelzer@jit-tecnologia.com.br',
                'email_from_name' => 'JIT Tecnologia',
                'social_network' => json_decode('{"whatsapp":"555198530541","facebook":"jimmy.stelzer","instagram":"jimmystelzer","x_twitter":"jimmystelzer","youtube":"@JimmyStelzer","linkedin":"jimmystelzer","tiktok":"@silviosantosfrases","pinterest":"jimmystelzer"}'),
                'more_configs' => json_decode('{"alert_text":"\ud83d\udd25 Receba em 72h com FRETE GR\u00c1TIS\ud83d\udd25","rodape_1_titulo":"T\u00edtulo do rodap\u00e9 1","rodape_1":"Conte\u00fado do rodap\u00e9 1 <br>\nConte\u00fado do rodap\u00e9 1 <br>\nConte\u00fado do rodap\u00e9 1 <br>","rodape_2_titulo":"T\u00edtulo do rodap\u00e9 2","rodape_2":"Conte\u00fado do rodap\u00e9 2 <br>\nConte\u00fado do rodap\u00e9 2<br>\nConte\u00fado do rodap\u00e9 2 <br>","rodape_3_titulo":"T\u00edtulo do rodap\u00e9 3","rodape_3":"Conte\u00fado do rodap\u00e9 3 <br>\nConte\u00fado do rodap\u00e9 3 <br>\nConte\u00fado do rodap\u00e9 3 <br>","stripe_public_key":"pk_test_51PpJ7sP8UtFYn7nF3WeGgAn0OKWhvCvcyJEVlsVNuvuFwXDo3PHzENQF2l1qyBliLBwHgULn39RyypEdA4x6r26w00m09U6EhP","stripe_private_key":"sk_test_51PpJ7sP8UtFYn7nFSKqYLXyzFdiGGq0fCjtrE9SlwO47TjQLgmO1i7I5ALsPeBn2WLqO6PIkWoO21DCyS85dAly100GPLWAWta"}'),
            ]
        );

        User::factory(3)->create();

        Address::factory(8)->create();

        $states = [
            ['state' => 'Acre', 'acronym_state' => 'AC'],
            ['state' => 'Alagoas', 'acronym_state' => 'AL'],
            ['state' => 'Amapá', 'acronym_state' => 'AP'],
            ['state' => 'Amazonas', 'acronym_state' => 'AM'],
            ['state' => 'Bahia', 'acronym_state' => 'BA'],
            ['state' => 'Ceará', 'acronym_state' => 'CE'],
            ['state' => 'Distrito Federal', 'acronym_state' => 'DF'],
            ['state' => 'Espírito Santo', 'acronym_state' => 'ES'],
            ['state' => 'Goiás', 'acronym_state' => 'GO'],
            ['state' => 'Maranhão', 'acronym_state' => 'MA'],
            ['state' => 'Mato Grosso', 'acronym_state' => 'MT'],
            ['state' => 'Mato Grosso do Sul', 'acronym_state' => 'MS'],
            ['state' => 'Minas Gerais', 'acronym_state' => 'MG'],
            ['state' => 'Pará', 'acronym_state' => 'PA'],
            ['state' => 'Paraíba', 'acronym_state' => 'PB'],
            ['state' => 'Paraná', 'acronym_state' => 'PR'],
            ['state' => 'Pernambuco', 'acronym_state' => 'PE'],
            ['state' => 'Piauí', 'acronym_state' => 'PI'],
            ['state' => 'Rio de Janeiro', 'acronym_state' => 'RJ'],
            ['state' => 'Rio Grande do Norte', 'acronym_state' => 'RN'],
            ['state' => 'Rio Grande do Sul', 'acronym_state' => 'RS'],
            ['state' => 'Rondônia', 'acronym_state' => 'RO'],
            ['state' => 'Roraima', 'acronym_state' => 'RR'],
            ['state' => 'Santa Catarina', 'acronym_state' => 'SC'],
            ['state' => 'São Paulo', 'acronym_state' => 'SP'],
            ['state' => 'Sergipe', 'acronym_state' => 'SE'],
            ['state' => 'Tocantins', 'acronym_state' => 'TO'],
        ];

        foreach ($states as $state) {
            State::create($state);
        }
            
        Category::factory(5)->create();
        Shipping::factory(10)->create();

        Product::factory(50)->create();

        Order::factory(18)->create();
        OrderItem::factory(80)->create();

        Order::all()->each(function (Order $order) {
            $sum = 0.0;
            $order->items->each(function (OrderItem $item) use (&$sum) {
                $sum += $item->total_price;
            });
            $order->update(['subtotal' => $sum]);
        });
        Banner::factory(8)->create();

        Menu::factory(20)->create();
    }
}
