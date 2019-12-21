<?php

use app\models\Customer;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'login',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a($model->login, ['update', 'id' => $model->id]);
                }
            ],
            'first_name',
            'last_name',
            'email:email',
            [
                'attribute' => 'created_at',
                'format' => ['datetime', 'php:d.m.Y'],
                'filter' => DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'createdAtRange',
                    'convertFormat' => true,
                    'startAttribute' => 'dateStart',
                    'endAttribute' => 'dateEnd',
                    'pluginOptions' => [
                        'locale' => ['format' => 'd.m.Y'],
                    ]
                ])
            ],
            [
                'attribute' => 'sex',
                'filter' => Customer::getSexMap(),
                'value' => function ($model) {
                    return Customer::getSexMap()[$model->sex];
                }
            ],

            [
                'class' => \yii\grid\ActionColumn::className(),
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>


</div>
