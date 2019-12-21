<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AddressSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Адресы';
?>
<div class="address-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'country',
            'city',
            'street',
            'house_number',
            'office_number',
            'post_index',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{create} {update} {delete}',
                'buttons' => [
                    'create' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-plus"></span>', ['/address/create', 'customer_id' => $model->customer_id], [
                            'title' => 'Создать',
                            'target' => '_blank'
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/customer/update', 'id' => $model->customer_id], [
                            'title' => 'Создать',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/address/delete', 'id' => $model->id], [
                            'title' => 'Создать',
                            'data' => [
                                'method' => 'post',
                                'confirm' => 'Вы уверены, что хотите удалить адрес?'
                            ]
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>


</div>
