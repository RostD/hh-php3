<?php
/**
 * Created by PhpStorm.
 * User: Rostislav
 * Date: 14.06.2017
 * Time: 12:27
 */

namespace app\controllers;



use Yii;
use yii\web\Controller;

class ProjectController extends Controller
{
    
    public function actionGetJs()
    {
        Yii::$app->response->format = 'javascript';

        return ('alert("I\'m JavaScript file creating in '.__METHOD__.'")');
    }
}