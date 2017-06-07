<?php
/**
 * Created by PhpStorm.
 * User: guoxiaosong
 * Date: 2016/10/25
 * Time: 10:04
 */
namespace mztest\infiniteLevel;

use yii\web\AssetBundle;

class InfiniteLevelAsset extends AssetBundle
{
    public $sourcePath = __DIR__ .'/assets';

    public $js = [
        'js/jquery.infiniteLevel.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}