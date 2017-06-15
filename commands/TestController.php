<?php
/**
 * Created by PhpStorm.
 * User: Rostislav
 * Date: 14.06.2017
 * Time: 20:35
 */

namespace app\commands;


use yii\console\Controller;

class TestController extends  Controller
{
    public function actionIndex()
    {

        cli_set_process_title("DateProcess");

        if(!function_exists(pcntl_fork()) || !function_exists(posix_setsid()))
            echo "Doesn't exists";
        else
            echo "Exists";


        while(true)
        {
            echo "\n".date('d/m/Y, H:i:s');
            sleep(3);
        }

    }
}