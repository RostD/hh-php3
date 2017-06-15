<?php
/**
 * Created by PhpStorm.
 * User: Rostislav
 * Date: 14.06.2017
 * Time: 14:18
 */
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>
<h1>Статистка проектов на 2016 год</h1>
<table class="table">
    <tr>
        <th>ID</th>
        <th>Наименование</th>
        <th>Среднее кол-во действий по звонкам</th>
        <th>Действий "transfer"</th>
    </tr>
    <?php foreach ($projects as $project): ?>
    <tr>
        <td><?= $project['id']?></td>
        <td><?= $project['name']?></td>
        <td><?= $project['mean_actions']?></td>
        <td><?= $project['total_transfer_actions']?></td>

    </tr>

    <?php endforeach; ?>
</table>

<?= LinkPager::widget(['pagination'=>$pagination])?>

