# Bootcamp maryUI com Livewire.

https://mary-ui.com/bootcamp/01

- Livewire: https://livewire.laravel.com/
- Laravel 11: https://laravel.com/docs/11.x/installation
- maryUI: https://mary-ui.com/
- Crie uma conta no TinyMCE: https://www.tiny.cloud/
    - Adicione a API key no app.blade.php a sessao {{-- TinyMCE --}}

# Sobre

Passeando por componentes maryUI com Livewire usando Volt. 

O projeto contempla:

- Autenticação: Login e Register
- Crud de usuarios: 
    - Listagem com filtros e paginação e opção de ordenação e delete
    - Criação e edição de usuários: Crop de image, bio com token de TinyMCE, Password
    - Logout

# Clone o projeto e comece por aqui:

Em uma aba do terminal:

```
composer install
```

```
yarn dev # or `npm run dev`
```

Em outra aba do terminal:

```
php artisan storage:link
```

```
php artisan serve
```