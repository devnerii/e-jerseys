<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		$user = new User();
        $user->fill([
            'name' => 'Administrador',
            'email' => 'admin@admin.com.br',
            'password' => bcrypt('123456'),
            'is_admin' => true,
        ]);
		$user->save();

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
    }
}
