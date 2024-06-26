# Teste Infornet

O projeto consiste em uma API Rest utilizado por uma assistência 24 horas, onde há o cadastro de prestadores, e busca pelos mesmos.

## Ferramentas utilizadas
* PHP 8.3
* Laravel 11
* Pest PHP
* MySQL


# Instruções
Para este projeto é necessário um ambiente com PHP 8.3, MySQL versão 5.8 > e o composer. Sugiro utilizá-lo com o Docker, onde para instalar e executar o container utilizamos o Sail do Laravel. Nas instruções abaixo é explicado como é feita a instalação do Sail.

1.  Rode o comando `cp .env.example .env` para criar o arquivo .env , ou copie manualmente o arquivo .env.example e renomeie-o para .env.
2. Dentro da pasta clonada do projeto, instale as dependências rodando o comando `composer install`.
3. Gere o App key da aplicação com o comando `php artisan key:generate`.
4. Gere o Secret do JWT com o comando `php artisan jwt:secret`.
5. Com o Docker previamente instalado, instale o Sail com o seguinte comando: `php artisan sail:install`.
6. Selecione os serviços a serem instalados, no caso deste teste é necessário somente o mysql, sendo assim, aperte enter.
7. Após instalado suba o container com o seguinte comando, dentro da pasta do projeto: `./vendor/bin/sail up -d`.
8. Agora execute o seguinte comando para fazer a migração: `./vendor/bin/sail artisan migrate`. Ou caso não esteja utilizando o sail, basta rodar o mesmo comando, porém com o php no lugar do ./vendor/bin/sail .
9. Execute os seeders com o comando `./vendor/bin/sail artisan db:seed`.
10. No .env, coloque as credenciais para a API da Infornet, nas chaves INFORNET_CLIENT_USER e INFORNET_CLIENT_PASSWORD.

# Utilização da Rest API
Para utilizar a API Rest você deve utilizar um client HTTP como Postman ou Insomnia.

O primeiro passo deve ser registrar um usuário utilizando o endpoint de registro.

Você pode consultar todos os endpoints disponíveis na documentação do postman [neste link](https://documenter.getpostman.com/view/10694302/2sA3drJufL#6eed4633-e4da-483a-a76b-2f852b638f1d)

Enjoy :)