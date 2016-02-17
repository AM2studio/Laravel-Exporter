# Laravel-Laravel-Exporter

Package contains trait for exporting documents

## Install

Via Composer

``` bash
$ composer require am2studio/laravel-exporter
```

## Usage


Trait in controller :
```php
/**
 * Class UserController
 * @package App\Http\Controllers\Backend\Admin
 */
class UserController extends Controller
{
    use \AM2Studio\Laravel\Exporter\Exporter;
```

Using trait function in controller

```php
/**
 * @return mixed
 */
public function csv()
{
    $users = (new User)->paginate(10);
    return $this->exportOneSheet(
        $users,
        ['first_name' => 'First name', 'last_name' => 'Last Name', 'gender' => 'Gender'],
        'Users', 'users', 'xls', 'Creator', 'Company'
    );
}
```

First parameter in  \Illuminate\Pagination\LengthAwarePaginator

Second parameter is array with attribute name in db and title in export

Rest parameters are

    title for document
    filename for document
    format for document (xsl,pdf etc.)
    document creator
    document company
    

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
