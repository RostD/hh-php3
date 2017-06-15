<?php
/**
 * Created by PhpStorm.
 * User: Rostislav
 * Date: 14.06.2017
 * Time: 12:27
 */

namespace app\controllers;


use app\models\Project;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;

class ProjectController extends Controller
{
        
    public function actionProjectStatistics()
    {
        /**
         * I can't understand, how i can made this sql-query with relation yii2:
         *
            SELECT
               p.id project_id,
               p.name,
               sum(case ca.action when '1' then 1 else 0 end) total_transfer_action,
               ROUND ((count(ca.id)/count(distinct c.id)),2) as mean
            FROM projects p
            LEFT JOIN calls c ON p.id=c.project_id
            LEFT JOIN calls_actions ca ON ca.call_id=c.id
            WHERE c.creation_time >= '2016-01-01 00:00' AND c.creation_time <= '2016-12-31 23:59'

            GROUP BY p.id
            Order by p.name
         *
         * P.S.
         * Все индексы в базе уже имелись
         * 
         * UPDATE:
         * I know! actionTable with sql used yii2 relations created
         * Но по производительности расчеты на PHP выполняются быстрее (визуально)
         */
        $statistics = [];

        $query = Project::find();
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count()
        ]);

        $projects = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->with([
                'calls' => function ($query) {
                    $query->where("
                    creation_time >= '2016-01-01 00:00' AND 
                    creation_time <= '2016-12-31 23:59'");
                },
                'calls.actions',
            ])
            ->all();

        foreach ($projects as $project)
        {
            $count_calls = count($project->calls);
            $all_project_actions = 0;
            $transfer_project_actions = 0;

            foreach($project->calls as $call)
            {
                foreach ($call->actions as $call_action)
                {
                    $all_project_actions++;
                    //Find "transfer" call action
                    if($call_action->action == 1)
                        $transfer_project_actions++;
                }
            }

            if($count_calls == 0)
                $mean_actions = 0;
            else
                $mean_actions = $all_project_actions / $count_calls;
            
            $statistics[] = [
                'id' => $project->id,
                'name' => $project->name,
                'mean_actions' => $mean_actions,
                'transfer_actions' => $transfer_project_actions,
            ];
        }
        
        return $this->render('call-statistics',['statistics' => $statistics,'pagination'=>$pagination]);

    }

    public function actionGetJs()
    {
        Yii::$app->response->format = 'javascript';

        return ('alert("I\'m JavaScript file creating in '.__METHOD__.'")');
    }

    public function actionTable()
    {
        $query = Project::find();
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count()
        ]);

        $projects = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->joinWith(['calls','calls.actions'])
            ->select([
                'projects.id',
                'projects.name',
                'SUM(case calls_actions.action when \'1\' then 1 else 0 end) total_transfer_actions',
                'ROUND ((count(calls_actions.id)/count(distinct calls.id)),2) as mean_actions'
            ])
            ->where("
                    creation_time >= '2016-01-01 00:00' AND 
                    creation_time <= '2016-12-31 23:59'")
            ->groupBy('projects.id')
            ->orderBy('projects.name')
            ->with(['calls','calls.actions'])
            ->all();
        return $this->render('table',['projects' => $projects,'pagination'=>$pagination]);
    }
}