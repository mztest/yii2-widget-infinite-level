# yii2-widget-infinite-level

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist mztest/yii2-widget-infinite-level "*"
```

or add

```
"mztest/yii2-widget-infinite-level": "*"
```

to the require section of your `composer.json` file.

Usage
-----
Simply use it in your code by  :

    ```php
    use mztest\infiniteLevel\InfiniteLevel;
    <?= $form->field($model, 'parent_id')->widget(InfiniteLevel::className(), [
        'items' => [['value' => 'value1', 'label' =>'label1'], ['value' => 'value2', 'label' =>'label2']],
        'itemParents' => ['Parents ID here']
    ]) ?>
    ```