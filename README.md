<p align="center">
<img src="https://github.com/DeGraciaMathieu/php-smelly-code-detector/blob/master/arts/robot.png" width="250">
</p>

[![testing](https://github.com/DeGraciaMathieu/php-smelly-code-detector/actions/workflows/testing.yml/badge.svg)](https://github.com/DeGraciaMathieu/php-smelly-code-detector/actions/workflows/testing.yml)
[![phpstan](https://github.com/DeGraciaMathieu/php-smelly-code-detector/actions/workflows/phpstan.yml/badge.svg)](https://github.com/DeGraciaMathieu/php-smelly-code-detector/actions/workflows/phpstan.yml)

# php-smelly-code-detector
## Installation
Requires >= PHP 8.1
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
| --min-smell=                | Ignore methods with less than --min-smell         |
| --max-smell=                | Ignore methods with more than --max-smell         |
| --limit=              | Number of methods displayed.         |
| --without-constructor | Ignore method constructors from detection.         |
| --sort-by-smell      | Sort the results by the smell of methods.         |
## Examples
```
$ php smellyphpcodedetector inspect app --sort-by-smell --limit=10
❀ PHP Smelly Code Detector ❀
   81 [============================] < 1 sec
+-----------------------------------------------------------+---------------------------------+-------+
| Files                                                     | Methods                         | smell |
+-----------------------------------------------------------+---------------------------------+-------+
| app/Http/Controllers/Blog/AdminPostController.php         | update                          | 174   |
| app/Http/Controllers/Auth/NewPasswordController.php       | store                           | 87    |
| app/Console/Commands/FetchGoogleFonts.php                 | store                           | 78    |
| app/Http/Middleware/RedirectIfAuthenticated.php           | handle                          | 77    |
| app/Http/Controllers/User/ProfileController.php           | updateAvatar                    | 75    |
| app/Services/Community/CreatorRepository.php              | instantiateCreatorsFromResponse | 72    |
| app/Http/Controllers/Auth/PasswordResetLinkController.php | store                           | 51    |
| app/Http/Controllers/User/ProfileController.php           | updateInformations              | 51    |
| app/Http/Controllers/Auth/RegisteredUserController.php    | store                           | 50    |
| app/Http/Controllers/Blog/ShowPostController.php          | __invoke                        | 48    |
+-----------------------------------------------------------+---------------------------------+-------+
193 methods found.
```
