<?php
/**
 * Created by PhpStorm.
 * User: Rostislav
 * Date: 14.06.2017
 * Time: 19:55
 */

namespace app\components;


use yii\web\ResponseFormatterInterface;

class JSFormatter implements ResponseFormatterInterface
{
    public function format($response)
    {
        $response->getHeaders()->set('Content-Type', 'application/javascript');
        $response->content = $response->data;
    }
}