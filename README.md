# Reporto: Report browser errors to the server

[![Latest Version](https://img.shields.io/github/v/release/DevDavido/laravel-reporto.svg?style=flat-square)](https://github.com/DevDavido/laravel-reporto/releases)
[![Build Status](https://img.shields.io/github/actions/workflow/status/DevDavido/laravel-reporto/tests.yml?style=flat-square)](https://github.com/DevDavido/laravel-reporto/actions/workflows/tests.yml)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/DevDavido/laravel-reporto.svg?style=flat-square)](https://scrutinizer-ci.com/g/DevDavido/laravel-reporto/)
[![Total Downloads](https://img.shields.io/packagist/dt/DevDavido/laravel-reporto.svg?style=flat-square)](https://packagist.org/packages/DevDavido/laravel-reporto)

This package makes use of the [W3C Reporting API](https://w3c.github.io/reporting/) and provides an easy plug-and-play package for your existing project. It will automatically add the necessary Report HTTP headers and log all configured browser errors to your Laravel backend.

## Documentation

Find yourself stuck using the package? Found a bug? Do you have general questions or suggestions for improving this package? Feel free to [create an issue on GitHub](https://github.com/devdavido/laravel-reporto/issues), we'll try to address it as soon as possible.

If you've found a bug regarding security please mail github{at}diskoboss{døt}de instead of using the issue tracker.

## Minimum requirements

- PHP 8.0+
- Laravel 9+

For support of older PHP / Laravel versions, check out previous releases of this package.

## Installation

You can install this package via composer using this command:

```bash
composer require devdavido/laravel-reporto
```

The package will automatically register itself and add a `Report-To` header to your `web` routes.
Each error or violation will be logged to the backend.

You can publish the config-file with:

```bash
php artisan vendor:publish --provider="DevDavido\Reporto\ReportoServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
    /*
     * Use this setting to enable the reporting API header
     */
    'enabled' => env('REPORTING_API_ENABLED', true),

    /*
     * Enables the reporting API for all subdomains
     */
    'include_subdomains' => env('REPORTING_API_INCLUDE_SUBDOMAINS', false),

    /*
     * Exclude certain source files from being logged
     */
    'exclude_source_files' => env('REPORTING_API_EXCLUDE_SOURCE_FILES', ['chrome-extension://*']),

    /*
     * Defines cached lifetime of all endpoint in seconds (86400s = 1 day)
     */
    'endpoint_max_age' => env('REPORTING_API_MAX_AGE', 86400),

    /*
     * Which types of browser errors to report
     * @see https://w3c.github.io/reporting/
     */
    'groups' => [
        'default',
        'csp-endpoint',
        'network-errors'
    ],

    /*
     * If you want to set the logging route prefix
     */
    'route_prefix' => 'log'
];
```

## Support me

If you installed the package and it was useful for you or your business, please don't hesitate to make a donation. Thank you!

<a href="https://www.buymeacoffee.com/devdavido" target="_blank"><img src="https://github.com/DevDavido/laravel-reporto/assets/997605/b7e908c3-0407-4b17-83b7-94b760a4c653" width="180" alt="Buy me a coffee"></a>

## Testing

You can run the tests with:

```bash
vendor/bin/phpunit
```

## Ideas / ToDo

- Daily/weekly reports via email
- Multiple endpoints
- More unit tests

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security

If you discover any security related issues, please email github{at}diskoboss{døt}de instead of using the issue tracker.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze) for letting me use his packages as boilerplate.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
