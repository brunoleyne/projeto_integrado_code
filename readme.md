## Projeto Integrado - PUC Minas

Projeto criado para anamnese e controle de pacientes da clínica utilizando Framework Laravel

## Ambiente

Para o correto funcionamento é necessário ambiente os seguintes pré-requisitos:

- PHP 7.0 ou superior
- Composer
- Node.js com npm
- MySQL 5.5 ou superior
- Caso necessite subir ambiente rapidamente utilizar imagem docker php 7.1: Imagem Docker http://dockerfile.readthedocs.io/en/latest/content/DockerImages/dockerfiles/php-apache-dev.html

## Configurando Ambiente

- Renomear arquivo .env.example para .env
- Preencher arquivo .env com configurações do ambiente
- Rodar migrations utilizando: php artisan migrate
- Popular banco com seeders utilizando: php artisan db:seed
- Gerar chave de utilização para criptografia utilizando: php artisan key:generate
- Rodar comando: composer install
- Rodar comando: npm install
- Rodar comando: npm run dev ou npm run prod
