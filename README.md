<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Passos para rodar o projeto

- [Faça uma copia do arquivo ".env.example" para ".env"].
- [No arquivo ".env" insira os dados do banco(Foi utilizado o mysql)].
- [Dentro da pasta do projeto, execute o comando "composer update"].
- [Após o "composer update", execute o comando "php artisan key:generate"].
- [Após o comando "php artisan key:generate", execute o comando "php artisan migrate"].


## Passos para executar a rotina de agendamento
- [Registre-se através do menu inferior do lado direito na rota principal].
- [Após registrar-se você terá acesso ao painel, no menu superior acesse o menu "Agendar" para novos agendamentos].
- [Após acessar o menu "Agendar", selecione a especialidade e aguarde carregar os especialistas].
- [Escolha um especialista e clique em agendar, após isso o sistema irá abrir um modal para preencher os dados (Nome, com conheceu, data de nascimento e cpf)].
- [Após preenchimento dos dados acima, você pode solicitar os horarios disponiveis, após selecionar os horários você pode agendar a consulta].
- [Após agendamento da consulta você será redirecionado para o painel principal, listando assim suas consultas, você pode remover o agendamento caso queira].


## Itens utilizados
- [Webpack para versionamento e redução de tamanho dos arquivos js e css].
- [Cache para que não solicite várias requisições do mesmo item em um curto intervalo de tempo].
- [Componentização para melhor performance e organização].
- [Autenticação por email e senha].
- [Bootstrap 5](https://getbootstrap.com/).
- [Jquery 3](https://jquery.com/).
- [Laravel 9](https://laravel.com/docs/9.x).
- [Sweet Alert](https://sweetalert2.github.io/).
- [Jquery mask](https://igorescobar.github.io/jQuery-Mask-Plugin/).
- [Select 2](https://select2.org/).
- [PHP 7.4](https://www.php.net/).


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
