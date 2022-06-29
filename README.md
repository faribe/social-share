# Social Share

[![Latest Version on Packagist](https://img.shields.io/packagist/v/faribe/social-share.svg?style=flat-square)](https://packagist.org/packages/faribe/social-share)
[![Total Downloads](https://img.shields.io/packagist/dt/faribe/social-share.svg?style=flat-square)](https://packagist.org/packages/faribe/social-share)


Share links exist on almost every page in every project, creating the code for these share links over and over again can be a difficult at times.
With Laravel Share you can generate these links in just seconds in a way tailored for Laravel.

### Available services

* Facebook
* Twitter
* Linkedin
* WhatsApp
* Reddit
* Telegram
* Viber

## Installation

You can install the package via composer:

``` bash
composer require faribe/social-share
```


If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php

```php
// config/app.php
'providers' => [
    Faribe\SocialShare\SocialShareServiceProvider::class,
];
```

And optionally add the facade in config/app.php

```php
// config/app.php
'aliases' => [
    'SocialShare' => Faribe\SocialShare\SocialShareFacade::class,
];
```

Publish the package config & resource files.

```bash
php artisan vendor:publish --provider="Faribe\SocialShare\SocialShareServiceProvider"
```

> You might need to republish the config file when updating to a newer version of Laravel Share

This will publish the ```laravel-share.php``` config file to your config folder, ```share.js``` in ```public/js/``` folder.

### Fontawesome

Since this package relies on Fontawesome, you will have to require it's css, js & fonts in your app.
You can do that by requesting a embed code [via their website](http://fontawesome.io/get-started/) or by installing it locally in your project.

Laravel share supports Font Awesome v5. For Font Awsome 4 support use version [3](https://github.com/jorenvh/laravel-share/tree/3.3.1) of this package. 

### Javascript

Load jquery.min.js & share.js by adding the following lines to your template files.

```html
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
<script src="{{ asset('js/social-share.js') }}"></script>
```

## Usage

### Creating one share link

#### Facebook

``` php
SocialShare::page('http://faribe.be')->facebook();
```

#### Twitter

``` php
SocialShare::page('http://faribe.be', 'Your share text can be placed here')->twitter();
```

#### Reddit

``` php
SocialShare::page('http://faribe.be', 'Your share text can be placed here')->reddit();
```

#### Linkedin

``` php
SocialShare::page('http://faribe.be', 'Share title')->linkedin('Extra linkedin summary can be passed here')
```

#### Whatsapp

``` php
SocialShare::page('http://faribe.be')->whatsapp()
```

#### Telegram

``` php
SocialShare::page('http://faribe.be', 'Your share text can be placed here')->telegram();
```

#### Viber

``` php
SocialShare::page('http://faribe.be', 'Your share text can be placed here')->viber();
```

### Sharing the current url

Instead of manually passing an url, you can opt to use the `currentPage` function.

```php
SocialShare::currentPage()->facebook();
```

### Creating multiple share Links

If want multiple share links for (multiple) providers you can just chain the methods like this.

```php
SocialShare::page('http://faribe.be', 'Share title')
	->facebook()
	->twitter()
	->linkedin('Extra linkedin summary can be passed here')
    ->viber()
	->whatsapp();
```

This will generate the following html

```html
<div id="social-links">
	<ul>
		<li><a href="https://www.facebook.com/sharer/sharer.php?u=http://faribe.be" class="social-button " id=""><span class="fa fa-facebook-official"></span></a></li>
		<li><a href="https://twitter.com/intent/tweet?text=my share text&amp;url=http://faribe.be" class="social-button " id=""><span class="fa fa-twitter"></span></a></li>
		<li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=http://faribe.be&amp;title=my share text&amp;summary=dit is de linkedin summary" class="social-button " id=""><span class="fa fa-linkedin"></span></a></li>
		<li><a href="viber://forward?text=http://faribe.be" class="social-button " id=""><span class="fa fa-viber"></span></a></li>
        <li><a href="https://wa.me/?text=http://faribe.be" class="social-button " id=""><span class="fa fa-whatsapp"></span></a></li>    
	</ul>
</div>
```

### Getting the raw links

In some cases you may only need the raw links without any html, you can get these by calling the `getRawLinks` method.

**A single link**
```php
SocialShare::page('http://faribe.be', 'Share title')
	->facebook()
	->getRawLinks();
```

Outputs:

```html 
https://www.facebook.com/sharer/sharer.php?u=http://faribe.be
```

**Multiple links**

```php
SocialShare::page('http://faribe.be', 'Share title')
	->facebook()
	->twitter()
	->linkedin('Extra linkedin summary can be passed here')
	->whatsapp()
    ->getRawLinks();
```

Outputs:

```
[
  "facebook" => "https://www.facebook.com/sharer/sharer.php?u=http://faribe.be",
  "twitter" => "https://twitter.com/intent/tweet?text=Share+title&url=http://faribe.be",
  "linkedin" => "http://www.linkedin.com/shareArticle?mini=true&url=http://faribe.be&title=Share+title&summary=Extra+linkedin+summary+can+be+passed+here",
  "whatsapp" => "https://wa.me/?text=http://faribe.be",
]
```

### Optional parameters

#### Add extra classes, id's or titles to the social buttons

You can simply add extra class(es), id('s), title(s) or relationship(s) by passing an array as the third parameter on the page method.

```php
SocialShare::page('http://faribe.be', null, ['class' => 'my-class', 'id' => 'my-id', 'title' => 'my-title', 'rel' => 'nofollow noopener noreferrer'])
    ->facebook();
```

Which will result in the following html

```html
<div id="social-links">
	<ul>
		<li><a href="https://www.facebook.com/sharer/sharer.php?u=http://faribe.be" class="social-button my-class" id="my-id" rel="nofollow noopener noreferrer"><span class="fa fa-facebook-official"></span></a></li>
	</ul>
</div>
```

#### Custom wrapping

By default social links will be wrapped in the following html

```html
<div id="social-links">
	<ul>
		<!-- social links will be added here -->
	</ul>
</div>
```

This can be customised by passing the prefix & suffix as a parameter.

```php
SocialShare::page('http://faribe.be', null, [], '<ul>', '</ul>')
            ->facebook();
```

This will output the following html.

```html
<ul>
	<li><a href="https://www.facebook.com/sharer/sharer.php?u=http://faribe.be" class="social-button " id=""><span class="fa fa-facebook-official"></span></a></li>
</ul>
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email abdulla.fareez@gmail.com instead of using the issue tracker.

## Credits

- [Joren Van Hocht](https://github.com/jorenvh)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
