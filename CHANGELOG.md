# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [6.0.0] - 2024-03-12
[6.0.0]: https://github.com/eureka-framework/component-web/compare/5.3.0...6.0.0
### Changed
- Now support PHP 8.3
- Update Makefile
- Update composer.json
- Update GitHub workflow
### Added
- Add php-cs-fixer as linter
### Removed
- Drop PHP 7.4 & 8.0 support
- Remove PHPCS dependency


--- 

## [5.3.0] - 2023-06-15
[5.3.0]: https://github.com/eureka-framework/component-web/compare/5.2.0...5.3.0
### Changed
- Now compatible with PHP 8.2
- Update Makefile
- Update composer.json
- Update GitHub workflow
### Added
- Add phpstan config for PHP 8.2 compatibility

## [5.2.0] - 2022-09-09
[5.2.0]: https://github.com/eureka-framework/component-web/compare/5.1.0...5.2.0
### Added
 * Menu: Support of route parameters in menu yaml file 

## [5.1.0] - 2022-09-02
[5.1.0]: https://github.com/eureka-framework/component-web/compare/5.0.1...5.1.0
### Changed
 * CI improvements (php compatibility check, makefile, github workflow)
 * Now compatible with PHP 7.4, 8.0 & 8.1
### Added
 * phpstan for static analysis
### Removed
 * phpcompatibility (no more maintained)

## [5.0.1] - 2020-10-29
### Changed
 * Require phpcodesniffer v0.7 for composer 2.0

## [5.0.0] - 2020-10-29
### Changed
 * New require PHP 7.4+
 * All collections now use an abstract class (menu, breadcrumb, carousel & notifications)
 * Minor fixed & improvements
### Added
 * Session + trait for controller
 * Global collection abstract class
 * Added tests
### Removed
 * Flash notification class (now handled directly in session trait + session)
 * Compilation for phar archive: this component must be included with composer


## [3.x.y] Release v3.x.y
### Changed
 * Now require PHP 7+ (for classes Table\*)
 * Add new Table\* classes to manage table in CLI more properly
 * Allow multiple base namespace
 * Add Eureka\Component as default

## [2.x.y] Release v2.x.y
### Changed
  * Move code
  * Separate Style & Color
  * Move compilation code
  * Some update / fix
  * Update phpdoc
### Added
  * Add Table cli generation
 


## [1.0.0] - 2019-04-03
### Added
  * Add Breadcrumb item & controller aware trait
  * Add Flash notification service & controller aware trait
  * Add Menu item & controller aware trait
  * Add meta controller aware trait
  * Add Notification item
