> # Kilex
>
> Bridge between [Cilex](https://github.com/Cilex/Cilex) and [Silex](https://github.com/silexphp/Silex).

## [Documentation](https://github.com/kamilsk/Kilex/wiki)

## Examples of usage

### [Cilex Service Providers](https://github.com/kamilsk/CilexServiceProviders)

### [Silex Service Providers](https://github.com/kamilsk/SilexServiceProviders)

## Installation

### Git (development)

[Fork it before](https://github.com/kamilsk/Kilex/fork).

```bash
$ git clone git@github.com:<your github account>/Kilex.git
$ cd Kilex && composer install
$ git remote add upstream git@github.com:kamilsk/Kilex.git
```

#### Mirror

```bash
$ git remote add mirror git@bitbucket.org:kamilsk/kilex.git
```

### Composer (production)

#### Cilex

```bash
$ composer require kamilsk/cilex-service-providers:~4.0
```

#### Silex

```bash
$ composer require kamilsk/silex-service-providers:~2.0
```

## Pulse of repository

| Version / PHP | 5.5 | 5.6 | 7.0 | HHVM | Support                                           |
|:-------------:|:---:|:---:|:---:|:----:|:--------------------------------------------------|
| 1.0.x         | +   | +   | +   | +    | Security support and bug fixing until 10 Jul 2016 |
| 1.1.x LTS     | -   | +   | +   | +    | Security support and bug fixing until 31 Dec 2018 |
| 2.x           | -   | -   | +   | +    | Active support and new features until 3 Dec 2017  |

### [Changelog](CHANGELOG.md)

### General information

[![Build status](https://travis-ci.org/kamilsk/Kilex.svg?branch=2.x)](https://travis-ci.org/kamilsk/Kilex)
[![Tests status](http://php-eye.com/badge/kamilsk/kilex/tested.svg?branch=2.x)](http://php-eye.com/package/kamilsk/kilex)
[![Latest stable version](https://poser.pugx.org/kamilsk/kilex/v/stable.png)](https://packagist.org/packages/kamilsk/kilex)
[![License](https://poser.pugx.org/kamilsk/kilex/license.png)](https://packagist.org/packages/kamilsk/kilex)

### Code quality

[![Code coverage](https://scrutinizer-ci.com/g/kamilsk/Kilex/badges/coverage.png?b=2.x)](https://scrutinizer-ci.com/g/kamilsk/Kilex/?branch=2.x)
[![Scrutinizer code quality](https://scrutinizer-ci.com/g/kamilsk/Kilex/badges/quality-score.png?b=2.x)](https://scrutinizer-ci.com/g/kamilsk/Kilex/?branch=2.x)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/2a986f75-1b01-4dcf-882a-a2f842e22a9c/big.png)](https://insight.sensiolabs.com/projects/2a986f75-1b01-4dcf-882a-a2f842e22a9c)

### Stats

[![Total downloads](https://poser.pugx.org/kamilsk/kilex/downloads.png)](https://packagist.org/packages/kamilsk/kilex)
[![Monthly downloads](https://poser.pugx.org/kamilsk/kilex/d/monthly.png)](https://packagist.org/packages/kamilsk/kilex)
[![Daily downloads](https://poser.pugx.org/kamilsk/kilex/d/daily.png)](https://packagist.org/packages/kamilsk/kilex)
[![Total references](https://www.versioneye.com/php/kamilsk:kilex/reference_badge.svg)](https://www.versioneye.com/php/kamilsk:kilex/references)

### Feedback

[![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/kamilsk/small-tools)
[![@ikamilsk](https://img.shields.io/badge/author-%40ikamilsk-blue.svg)](https://twitter.com/ikamilsk)

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

### [package.meta](https://github.com/octolab/pmc)

We using `package.meta` to describe the package instead of `composer.json`.
Thus, changes in `composer.json` file directly is not allowed.

## Security

If you discover any security related issues, please email feedback@octolab.org instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
