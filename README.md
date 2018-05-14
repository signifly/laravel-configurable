# Easily make your Eloquent models configurable

[![Latest Version on Packagist](https://img.shields.io/packagist/v/signifly/laravel-configurable.svg?style=flat-square)](https://packagist.org/packages/signifly/laravel-configurable)
[![Total Downloads](https://img.shields.io/packagist/dt/signifly/laravel-configurable.svg?style=flat-square)](https://packagist.org/packages/signifly/laravel-configurable)

The `signifly/laravel-configurable` package allows you to easily make your Eloquent models configurable.

Below is a small example of how to use it.

```php
// Remember to add use statement
use Signifly\Configurable\Configurable;

class User
{
    use Configurable;
    
    // Remember to make `config` fillable
    protected $fillable = [
        'config',
    ];
    
    // Remember to add `config` to casts
    protected $casts = [
        'config' => 'array',
    ];
}
```

Adding the column to your table migration:

```php
Schema::table('users', function (Blueprint $table) {
    $table->config('config')->nullable();
});
```

Now you would be able to configure your user model:

```php
$user = User::find(1);
$user->config()->some_key = 'some val';
$user->config()->set('some_other_key', 'some other val');
$user->save();
```

Retrieving from your config is straightforward:

```php
$user = User::find(1);
$user->config()->some_key; // returns some val
$user->config()->get('some_other_key'); // return some other val
```

You can also overwrite the config key:

```php
// Remember to add use statement
use Signifly\Configurable\Configurable;

class User
{
    use Configurable;
    
    // Remember to make `settings` fillable
    protected $fillable = [
        'settings',
    ];
    
    // Remember to add `settings` to casts
    protected $casts = [
        'settings' => 'array',
    ];

    protected function getConfigKey()
    {
        return 'settings';
    }
}
```

## Documentation
Until further documentation is provided, please have a look at the tests.

## Installation

You can install the package via composer:

```bash
$ composer require signifly/laravel-configurable
```

The package will automatically register itself.

## Testing
```bash
$ composer test
```

## Security

If you discover any security issues, please email dev@signifly.com instead of using the issue tracker.

## Credits

- [Morten Poul Jensen](https://github.com/pactode)
- [All contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
