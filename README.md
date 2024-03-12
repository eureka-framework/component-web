# component-web

[![Current version](https://img.shields.io/packagist/v/eureka/component-web.svg?logo=composer)](https://packagist.org/packages/eureka/component-web)
[![Supported PHP version](https://img.shields.io/static/v1?logo=php&label=PHP&message=8.1%20-%208.3&color=777bb4)](https://packagist.org/packages/eureka/component-web)
![CI](https://github.com/eureka-framework/component-web/workflows/CI/badge.svg)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=eureka-framework_component-web&metric=alert_status)](https://sonarcloud.io/dashboard?id=eureka-framework_component-web)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=eureka-framework_component-web&metric=coverage)](https://sonarcloud.io/dashboard?id=eureka-framework_component-web)

## Description
Provide some utilities to website application:
 * Breadcrumb
 * Carousel
 * Menu
 * Meta
 * Notification
 * Session


## Composer
```bash
composer require "eureka/component-password"
```



## Contributing

See the [CONTRIBUTING](CONTRIBUTING.md) file.


### Install / update project

You can install project with the following command:
```bash
make install
```

And update with the following command:
```bash
make update
```

NB: For the components, the `composer.lock` file is not committed.

### Testing & CI (Continuous Integration)

#### Tests
You can run unit tests (with coverage) on your side with following command:
```bash
make tests
```

You can run integration tests (without coverage) on your side with following command:
```bash
make integration
```

For prettier output (but without coverage), you can use the following command:
```bash
make testdox # run tests without coverage reports but with prettified output
```

#### Code Style
You also can run code style check with following commands:
```bash
make phpcs
```

You also can run code style fixes with following commands:
```bash
make phpcsf
```

#### Check for missing explicit dependencies
You can check if any explicit dependency is missing with the following command:
```bash
make deps
```

#### Static Analysis
To perform a static analyze of your code (with phpstan, lvl 9 at default), you can use the following command:
```bash
make analyse
```

To ensure you code still compatible with current supported version at Deezer and futures versions of php, you need to
run the following commands (both are required for full support):

Minimal supported version:
```bash
make php81compatibility
```

Maximal supported version:
```bash
make php83compatibility
```

#### CI Simulation
And the last "helper" commands, you can run before commit and push, is:
```bash
make ci  
```

## License

This project is currently under The MIT License (MIT). See [LICENCE](LICENSE) file for more information.
