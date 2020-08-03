[![Latest Version](https://img.shields.io/github/release/riasvdv/statamic-collection-groups.svg?style=flat-square)](https://github.com/riasvdv/statamic-collection-groups/releases)

# Collection Groups

> Collection Groups for Statamic 3.

Group your collections into separate groups

## Installation

Require it using Composer.

```
composer require rias/statamic-collection-groups
```

Publish the configuration file

```
php artisan vendor:publish --provider="Rias\CollectionGroups\ServiceProvider"
```

The config file will be in config/statamic/collection-groups.php.

You can create groups by providing an array in the config file:

```php
<?php
return [
    'Group 1 label' => [
        'collection_handle_1',
        'collection_handle_2',
    ],
    'Group 2 label' => [
        'collection_handle_3',
        'collection_handle_4',
    ]
];
```

---
Brought to you by [Rias](https://rias.be)
