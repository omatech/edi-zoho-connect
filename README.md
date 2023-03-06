# Edi Zoho Connect

[![Latest Version on Packagist](https://img.shields.io/packagist/v/omatech/zoho-forms.svg?style=flat-square)](https://packagist.org/packages/omatech/zoho-forms)
[![Total Downloads](https://img.shields.io/packagist/dt/omatech/zoho-forms.svg?style=flat-square)](https://packagist.org/packages/omatech/zoho-forms)

## Installation

You can install the package via composer:

```bash
composer require omatech/edi-zoho-connect
```

Create ``zoho_forms`` table.

```bash
php artisan migrate
```

Add to ``.env`` the following keys to connect to ZOHO:

````
ZOHO_OWNER
ZOHO_URL
ZOHO_TOKEN
ZOHO_SEND_FORMS=true
ZOHO_ERROR_MAIL_TO=
````

## Usage

### Custom Forms

Create your own forms using the following command:

```bash
php artisan zoho-forms:create
```

It will ask the filename and the zoho form type (leads/campaigns)

Once the file is created you can overwrite the content to adapt it to your needs.

### Send forms to ZOHO

```bash
php artisan zoho-forms:send
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email sarroyo@omatech.com instead of using the issue tracker.

## Credits

- [Sònia Arroyo](https://github.com/omatech)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
