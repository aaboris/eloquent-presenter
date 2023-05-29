# Presenter for Eloquent models

## Install

```bash
composer require borisnedovis/eloquent-presenter
```

## Usage

Create presenter class and extend it from ```aaboris\EloquentPresenter\AbstractPresenter```. And specify ```$attributes``` keys, which presenter should use from model:
```php
namespace App\Presenters;

use BorisNedovis\EloquentPresenter\AbstractPresenter;

class UserPresenter extends AbstractPresenter
{
    /**
     * @var \App\Models\User
     */
    protected $model;
    
    protected $attributes = [
        'first_name',
        'last_name'
    ];
}
```

Additionally you can add method for getting specific values:
```php
protected $attributes = [
    'first_name',
    'last_name',
    'full_name', // <- a virtual key, that model doesnt contain
];

// Get virtual value. Just studly case your key and surround it with 'get' and 'Attribute'.
public function getFullNameAttribute()
{
    return "{$this->model->first_name} {$this->model->last_name}";
}
```


Include trait ```BorisNedovis\EloquentPresenter\Presenter``` in your model. And specify presenter class.
```php
use BorisNedovis\EloquentPresenter\Presenter;

class User
{
    use Presenter;
    // ...

    protected $presenter = \App\Presenters\UserPresenter::class;

}
```

Or override ```getPresenterClass``` method, if you dont like protected attribute, or just need some extra logic:
```php
class User
{
    use Presenter;
    // ...

    public function getPresenterClass()
    {
        if ($this->isBlocked()) {
            return \App\Presenters\BlockedUserPresenter::class;
        }

        return \App\Presenters\UserPresenter::class;
    }

}
```

And just send it to output:
```php
$user = User::first();

return response()->json(compact('user'));
```
```json
{
    "first_name": "Boris",
    "last_name": "Nedovis",
    "full_name": "Boris Nedovis",
}
```


## License
The MIT License (MIT). Please see [LICENSE](https://github.com/BorisNedovis/eloquent-presenter/blob/master/LICENSE) for more information.
