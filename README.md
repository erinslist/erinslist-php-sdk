Erinslist PHP SDK
============================

PHP SDK for [Erinslist API](https://www.erinslist.us/docs/api/).

## Installation
```term
$ composer require erinslist/erinslist-php-sdk
```

## Usage
```php

const ERL_API_KEY = 'YOUR_ERL_API_KEY';
const ERL_API_SECRET = 'YOUR_ERL_SECRET_KEY';

$erl = new \Erinslist\Erinslist(ERL_API_KEY, ERL_API_SECRET);
$result = $erl->evaluate('3239 110th St, East Elmhurst, NY, 11369');

print_r($result);
```

## License
Released under the [MIT License](http://opensource.org/licenses/MIT).
See [LICENSE](LICENSE) file.