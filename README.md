Yii2 Storage
============
Yii2 Storage

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist nvlad/yii2-storage "*"
```

or add

```
"nvlad/yii2-storage": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

Add Storage Component to config (Local Backend)

```php
'storage' => [
    'class' => 'nvlad\storage\Storage',
    'driver' => [
        'class' => 'nvlad\storage\storages\Local',
        'path' => '@webroot/uploads'
    ]
],
```

Add Upload Action

```php
public function actions()
{
    return [
        'upload' => [
            'class' => 'nvlad\storage\UploadAction',
            'storage' => Yii::$app->storage,
            'name' => 'Filedata',
        ]
    ];
}
```
