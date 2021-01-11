# About Laravel Pages

Laravel pages is a package for laravel that allows you to represent your views with a PHP class

This package offers 2 type of class :

- Static (like home page)
- Dynamic (eloquent model)

Works with joedixon/laravel-translation & spatie/laravel-translatable

## Installation

You can install package via composer.json

``` json
...
"require": {
    ...
    "sideapps/laravel-pages": "^1.0.2"
},
...
"repositories": [
    ...
    {
        "type": "vcs",
        "url": "https://github.com/julien-culieras/laravel-pages"
    }
]
```

## Usage

### Static page

``` bash
php artisan page:static TestStaticPage
```

``` php
namespace App\Pages;

use Sideapps\LaravelPages\Breadcrumb\Breadcrumb;
use Sideapps\LaravelPages\Pages\StaticPage;
use Sideapps\LaravelPages\Pages\Page;

class TestStaticPage extends StaticPage implements Page {

    protected static string $translation_key = 'test_page';

    protected static string $route = 'test';

    public function getBreadcrumb():?Breadcrumb {
        return new Breadcrumb([
            $this->getBreadcrumbItem(false) // set false for not clickable anchor
        ]);
    }

}
```

``` php
class StaticPageController extends Controller {

    private CreatePageFactory $createPageFactory;

    public function __construct(CreatePageFactory $createPageFactory) {
        $this->createPageFactory = $createPageFactory;
    }

    public function test() {
        $page = $this->createPageFactory->getPage(TestStaticPage::class);
        return view('static.test', compact('page'));
    }

    ...

}
```

You must be create translation file for your page and set up these attributes (editable in the config or for each class page):

- meta_title
- meta_description
- fil_ariane
- titre_h1

### Dynamic page

``` bash
php artisan page:dynamic PostPage
```

``` php
namespace App\Pages;

use Sideapps\LaravelPages\Breadcrumb\Breadcrumb;
use Sideapps\LaravelPages\Pages\DynamicPage;
use Sideapps\LaravelPages\Pages\Page;

class PostPage extends DynamicPage implements Page {

    protected static string $route = 'posts.show';

    protected static array $routeParams = ['slug'];

    public function getBreadcrumb():?Breadcrumb {
        return new Breadcrumb([
            $this->createPageFactory->getPage(HomePage::class)->getBreadcrumbItem(),
            $this->getBreadcrumbItem(false) // set false for not clickable anchor
        ]);
    }

}
```

``` php
class Post extends Model implements Pageable {

    use HasTranslations;

    public array $translatable = [
        'meta_title', 'meta_description', 'title', 'html_content', 'slug'
    ];
 
    public function getPage():Page {
        return CreatePageFactory::make()->getPage(PostPage::class, $this);
    }

}
```

``` php
class PostController extends Controller {
    
    ...

    public function show(string $locale, string $slug) {
        $post = $this->postRepository->findBySlug($slug);
        $page = $post->getPage();
        return view('categoryCity.show', compact('post', 'page'));
    }

}
```


Your eloquent model must implements Pageable Interface & had these attributes :

- meta_title
- meta_description
- breadcrumb
- title

### Global

You now have a $page variable in all your blade views. You can also use it in layout, for example :

``` php
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ $page->getMetaTitle() }} - Sex With Me</title>
    <meta name="description" content="{{ $page->getMetaDescription() }}">
    {!! $page->generateAlternateLinks() !!}
</head>

<body>
    {!! $page->generateSwitchLanguageLinks() !!}
    {!! $page->generateBreadcrumb() !!}
    @yield('content')
</body>

</html>
```
