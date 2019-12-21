<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Address */
/* @var $customer_id int */

$this->title = 'Добавить адрес';
$customer = \app\models\Customer::findOne($customer_id);
$this->params['breadcrumbs'][] = ['label' => $customer->login, 'url' => ['/customer/view', 'id' => $customer_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="address-create">

    <h3><?= "Добавить адрес для " . Html::a($customer->login, ['/customer/view', 'id' => $customer_id]) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
