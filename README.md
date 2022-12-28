<p align="center">
<img src="https://github.com/DeGraciaMathieu/php-smelly-code-detector/blob/master/arts/robot.png" width="250">
</p>

[![build](https://github.com/DeGraciaMathieu/php-smelly-code-detector/actions/workflows/build.yml/badge.svg)](https://github.com/DeGraciaMathieu/php-smelly-code-detector/actions/workflows/build.yml)
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
| --min-smell=                | Ignore methods with less than --min-smell arguments.         |
| --max-smell=                | Ignore methods with more than --max-smell arguments.         |
| --limit=              | Number of methods displayed.         |
| --without-constructor | Ignore method constructors from detection.         |
| --sort-by-smell      | Sort the results by the smell of methods.         |
## Examples
```
$ php smellyphpcodedetector inspect app  --sort-by-smell --limit=10
❀ PHP Smelly Code Detector ❀
Scan in progress ...
193 methods found.
+--------------------------------------------------------+---------------------------------+-------+
| Files                                                  | Methods                         | smell |
+--------------------------------------------------------+---------------------------------+-------+
| app/Http/Controllers/Blog/AdminPostController.php      | update                          | 54    |
| app/Http/Controllers/Forum/CommentController.php       | store                           | 28    |
| app/Http/Middleware/RedirectIfAuthenticated.php        | handle                          | 27    |
| app/Http/Controllers/Auth/NewPasswordController.php    | store                           | 27    |
| app/Http/Controllers/Forum/CommentController.php       | update                          | 27    |
| app/Services/Markdown/FencedCodeRenderer.php           | render                          | 24    |
| app/Console/Commands/FetchGoogleFonts.php              | store                           | 24    |
| app/Http/Controllers/Auth/RegisteredUserController.php | store                           | 23    |
| app/Http/Controllers/User/ProfileController.php        | updateAvatar                    | 23    |
| app/Services/Community/CreatorRepository.php           | instantiateCreatorsFromResponse | 22    |
+--------------------------------------------------------+---------------------------------+-------+
```
