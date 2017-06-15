<?php
/**
 * Created by PhpStorm.
 * User: Rostislav
 * Date: 14.06.2017
 * Time: 13:30
 */

namespace app\models;


use yii\db\ActiveRecord;

class CallAction extends ActiveRecord
{
    static public function tableName()
    {
        return 'calls_actions';
    }
    
    public function getCall()
    {
        return $this->hasOne(Call::class,['id'=>'call_id']);
    }
}