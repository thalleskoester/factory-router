# Factory Router

[![Maintainer](http://img.shields.io/badge/maintainer-@thallesdella-blue.svg?style=flat-square)](https://github.com/thallesdella)
[![Source Code](http://img.shields.io/badge/source-thallesdella/factory--router-blue.svg?style=flat-square)](https://github.com/thallesdella/factory-router)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/thallesdella/factory-router.svg?style=flat-square)](https://packagist.org/packages/thallesdella/factory-router)
[![Latest Version](https://img.shields.io/github/release/thallesdella/factory-router.svg?style=flat-square)](https://github.com/thallesdella/factory-router/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build](https://img.shields.io/scrutinizer/build/g/thallesdella/factory-router.svg?style=flat-square)](https://scrutinizer-ci.com/g/thallesdella/factory-router)
[![Quality Score](https://img.shields.io/scrutinizer/g/thallesdella/factory-router.svg?style=flat-square)](https://scrutinizer-ci.com/g/thallesdella/factory-router)
[![Total Downloads](https://img.shields.io/packagist/dt/thallesdella/factory-router.svg?style=flat-square)](https://packagist.org/packages/thallesdella/factory-router)


Factory Router é um componente simples, que te ajuda na criação das rotas do seu sistema. Utilizando o motor de rotas
 [Router](https://github.com/robsonvleite/router), ele roteia o gerenciamento das rotas para alguma classe a sua escolha. 


### Destaques

- Instalação simples
- Facil utilização
- Pronto para o composer e compatível com PSR-2

## Instalação

Factory Router esta disponível atraves do composer:

```bash
"thallesdella/factory-router": "^1.2"
```

Ou execute

```bash
composer require thallesdella/factory-router
```

## Documentação

### Construindo objeto

* **FactoryRouter::class**(string **$projectUrl**, string **$namespace**)

    * **$projectUrl**: Url base do projeto
    * **$namespace**: Namespace padrão dos controllers
    
```php
$factory = new FactoryRouter('http://exemple.com.br', 'Source\Controllers');
```

_OBS: O namespace pode ser alterado durante a execução._

### Adicionando arquivo ou pasta

* **FactoryRouter::addFile**(string **$file**): _**FactoryRouter**_

    * **$file**: Url base do projeto
    
```php
$factory = new FactoryRouter('http://exemple.com.br', 'Source\Controllers');

try{
    $factory->addFile('widgets/cart/routes.php');
} catch (ClassNotFoundException $e){
 
} catch (UpdateRouterMissingMethodException $e){
   
} catch (FileNotFoundException $e){
    
}
```

* **FactoryRouter::addDir**(string **$dir**): _**FactoryRouter**_

    * **$dir**: Url base do projeto
    
```php
$factory = new FactoryRouter('http://exemple.com.br', 'Source\Controllers');

try{
    $factory->addDir('routes');
} catch (ClassNotFoundException $e){
 
} catch (UpdateRouterMissingMethodException $e){
  
} catch (DirectoryNotFoundException $e){
   
} catch (FileNotFoundException $e){
    
}
```

### Obtendo objeto Router

* **FactoryRouter::build**(): _**Router**_

```php
$factory = new FactoryRouter('http://exemple.com.br', 'Source\Controllers');

try{
    $factory->addDir('routes');
} catch (ClassNotFoundException $e){
 
} catch (UpdateRouterMissingMethodException $e){
  
} catch (DirectoryNotFoundException $e){
   
} catch (FileNotFoundException $e){
    
}

$router = $factory->build();
```

## Criando uma classe gerente do Router

Crie uma classe e extenda ela a classe Routes

* **Routes::class**(Router $router, string $className)

    * **$router**: objeto Router
    * **$className**: Nome da classe filha

* **Routes::updateRouter**(): _**Router**_

* **Routes::namespace**(?string **$ns**): _**Routes**_

    * **$ns**: Novo namespace

* **Routes::group**(?string **$group**): _**Router**_

    * **$group**: Nome do grupo

* **Routes::get**(string **$route**, string **$name**)

    * **$route**: Rota
    * **$name**: Apelido para a rota

* **Routes::post**(string **$route**, string **$name**)

    * **$route**: Rota
    * **$name**: Apelido para a rota

* **Routes::put**(string **$route**, string **$name**)

    * **$route**: Rota
    * **$name**: Apelido para a rota

* **Routes::delete**(string **$route**, string **$name**)

    * **$route**: Rota
    * **$name**: Apelido para a rota

```php
namespace Routes;

use ThallesDella\FactoryRouter\Routes;

class Blog extends Routes
{
    public function __construct(Router $router)
    {
        parent::__construct($router, __CLASS__);
    }
    
    public function updateRouter(): Router
    {
        $this->web();
        $this->categories();
        $this->posts();
        $this->user();
        return parent::updateRouter();
    }
    
    private function web(): void
    {
        $this->group(null);
        $this->get("/", "home");
        $this->get("/{search}", "search");
        $this->get("/contato", "contact");
    }
    
    private function categories(): void
    {
        $this->group('cat');
        $this->get("/", "categories");
        $this->get("/{cat_name}", "category");
    }
    
    private function posts(): void
    {
        $this->group('posts');
        $this->get("/", "posts");
        $this->get("/{post_name}", "post");
    }
    
    private function user(): void
    {
        $this->group('me');
        $this->get("/", "login");
        $this->get("/registrar", "register");
        $this->get("/recuperar", "forget");
        $this->get("/resetar", "reset");
    }
}
```

Para mais detalhes sobre como usar, veja na pasta de exemplos no diretório do componente. 

## Contribuindo

Por favor veja [CONTRIBUINDO](https://github.com/thallesdella/factory-router/blob/master/CONTRIBUTING.md) para detalhes.

## Suporte

Se você descobrir algum problema relacionado à segurança, envie um e-mail para thallesdella@gmail.com em vez de usar o rastreador de problemas.

Obrigado

## Créditos

- [Thalles D. Koester](https://github.com/thallesdella) (Desenvolvedor)
- [Todos os Contribuidores](https://github.com/thallesdella/factory-router/contributors) (Pessoas Incríveis)

## Licensa

Licensa MIT (MIT). Por favor veja [Arquivo de Licensa](https://github.com/thallesdella/factory-router/blob/master/LICENSE) para mais informações.