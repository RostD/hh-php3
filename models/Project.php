<?php
/**
 * Created by PhpStorm.
 * User: Rostislav
 * Date: 14.06.2017
 * Time: 12:16
 */

namespace app\models;


use yii\db\ActiveRecord;

class Project extends ActiveRecord
{
    public $total_transfer_actions;
    public $mean_actions;
    
    public static function tableName()
    {
        return 'projects';
    }

    public function getCalls()
    {
        return $this->hasMany(Call::class,['project_id'=> 'id']);
    }
}