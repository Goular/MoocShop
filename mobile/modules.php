<?php

namespace app\mobile;

/**
 * mobile module definition class
 */
class modules extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\mobile\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        \Yii::configure($this, require(__DIR__ . '/config.php'));
        // custom initialization code goes here
    }
}
