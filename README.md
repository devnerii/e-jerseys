# JIT Shop

## Instalação

Rode os seguintes comandos na pasta raiz para efetuar a instalação:

### Criação do arquivo de configuração:

Faça uma copia do arquivo de exemplo ".env.example" com o nome ".env":

`cp .env.example .env`

Edite o arquivo ".env" e presença as informações de banco de dados, servidor de email, link do site e nome do site.

### Instalação das dependências:

Instale as dependências do php

`composer install --optimize-autoloader --no-dev`

Instale as dependências do tema

`npm run build`

### Criação da chave de seção:

Crie a chave de seção usado para assegurar a segurança da aplicação

`artisan key:generate`

### Criação do banco de dados:

Crie as tabelas do banco de dados e aplique as regras de restrição e indicies

`artisan migrate`

Rode a geração de dados de produção

`artisan db:seed --class "Database\Seeders\ProdSeeder"`

### Acesse o link do site no /gerenciamento

Exemplo, se o link configurado no servidor for `https://jit-shop.com.br` acesse `https://jit-shop.com.br/gerenciamento` e faça o login na página utilizando as seguintes credenciais:

Usuário: `admin@admin.com.br`

Senha: `123456`

Vá para configurações e cadastre os dados de configuração.
Preencha os demais formulários com os dados apropriados para popular a loja.
