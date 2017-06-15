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
    // Чек файла на наличие pid уже запущенного процесса, если есть - проверить работает ли, если да то exit()

    //все stdin/out/err > /dev/null

    // форкнуть процесс
    // в дочернем процессе установить setsid(0)
    // закрыть все открытые дискрипторы, лучше от 0-1024
    // сделать dup() дескрипторов 1,2,3 и перенаправить в /dev/null
    // форкнуть второй раз
    // Запись текущего pid в файл


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