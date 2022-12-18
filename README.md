[![build](https://github.com/DeGraciaMathieu/php-smelly-code-detector/actions/workflows/build.yml/badge.svg)](https://github.com/DeGraciaMathieu/php-smelly-code-detector/actions/workflows/build.yml)
# php-smelly-code-detector
## Installation
Requires >= PHP 8.0
```
composer require degraciamathieu/php-smelly-code-detector --dev
```
## Usage
```
vendor/bin/smellyphpcodedetector inspect {folder}
```
## Options
| options               | description |
|-----------------------|-------------|
| --min-smell=                | Ignore methods with less than --min-smell arguments.         |
| --max-smell=                | Ignore methods with more than --max-smell arguments.         |
| --limit=              | Number of methods displayed.         |
| --without-constructor | Ignore method constructors from detection.         |
| --sort-by-smell      | Sort the results by the smell of methods.         |
## Examples
