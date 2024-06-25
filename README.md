# Teste Infornet

Sobre o projeto...

## Ferramentas utilizadas
* PHP 8.3
* Laravel 11
* Pest PHP
* MySQL


# Instruções
Para este projeto é necessário um ambiente com PHP 8.3, MySQL versão 5.8 > e o composer. Sugiro utilizá-lo com o Docker, onde para instalar e executar o container utilizamos o Sail do Laravel. Nas instruções abaixo é explicado como é feita a instalação do Sail.

1.  Rode o comando `cp .env.example .env` para criar o arquivo .env , ou copie manualmente o arquivo .env.example e renomeie-o para .env.
2. Dentro da pasta clonada do projeto, instale as dependências rodando o comando `composer install`.
3. Com o Docker previamente instalado, instale o Sail com o seguinte comando: `php artisan sail:install`.
4. Após instalado suba o container com o seguinte comando, dentro da pasta do projeto: `./vendor/bin/sail up -d`

# Utilização da Rest API
Para utilizar a API Rest você deve utilizar um client HTTP como Postman ou Insomnia.

A seguir temos todos os endpoints disponíveis assim como seus parâmetros e payloads.

## TODO

Enjoy :)
