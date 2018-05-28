<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/custom.css',
        'css/member-profile.css',
        'css/forms.css',
        'css/flag-icon.css',
    ];
    public $js = [
        'js/plugins/jspdf.min.js',
        'js/plugins/jspdf.plugin.autotable.js',
        'js/guardarpdf.js',
        'js/toggle.js',
        'js/comentarios.js',
        'js/profile.js',
        'js/extra.js',
        'js/delete-account.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
