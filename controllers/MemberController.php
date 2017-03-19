<?php

namespace app\controllers;

use app\models\User;

class MemberController extends \yii\web\Controller
{
    public function actionAuth()
    {
        $this->layout = "layout_parent_nav";


        $model = new User();
        return $this->render('auth', ['model' => $model]);
    }

}
