<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\forms\CustomerForm */

$this->title = 'Редактировать пользователя: ' . $model->customer->id;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->customer->login, 'url' => ['view', 'id' => $model->customer->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="customer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
