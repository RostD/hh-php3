<?php
/**
 * Created by PhpStorm.
 * User: Rostislav
 * Date: 14.06.2017
 * Time: 13:29
 */

namespace app\models;


use yii\db\ActiveRecord;

class Call extends ActiveRecord
{
    static public function tableName()
    {
        return 'calls';
    }

    public function getProject()
    {
        return $this->hasOne(Project::class,['id'=>'project_id']);
    }

    public function getActions()
    {
        return $this->hasMany(CallAction::class,['call_id'=>'id']);
    }
}