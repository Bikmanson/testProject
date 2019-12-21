<?php

use app\models\Address;
use app\models\Customer;
use app\widgets\newDynamicForm\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\forms\CustomerForm */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs(<<<JS
$(document).ready(function() {
    $(".remove-item").on("click", function(){
        let length = $('#body .addresses-item:nth-child(n)').length;
        let id = $(this).data("itemId");
        if (id !== 0 && length !== 1) { // 1 is the min value for items
            let deletedAddressIds = $("#deletedAddressIds");
            deletedAddressIds.val(deletedAddressIds.val() + "," + id);
        }
    });
});
JS
)
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin([
        'id' => 'customerForm'
    ]); ?>

    <div class="row">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success col-md-offset-10 col-md-2']) ?>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model->customer, 'login')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model->customer, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model->customer, 'first_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'password')->passwordInput(['id' => 'password']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model->customer, 'last_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'passwordRepeat')->passwordInput(['id' => 'passwordRepeat']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model->customer, 'sex')->dropDownList(Customer::getSexMap(), [
                'prompt' => 'Выберите пол'
            ]) ?>
        </div>
    </div>
    <br>
    <hr>
    <br>

    <?php
    DynamicFormWidget::begin([
        'widgetContainer' => 'addresses_dynamicform_wrapper',
        'widgetBody' => '.addresses-body',
        'widgetItem' => '.addresses-item',
        'min' => 1,
        'insertButton' => '.add-item',
        'deleteButton' => '.remove-item',
        'model' => $model->addresses[0],
        'formId' => 'customerForm',
        'formFields' => ['post_index', 'country', 'city', 'street', 'house_number', 'office_number'],
    ]);
    ?>

    <div id="body" class="addresses-body row">
        <?= Html::hiddenInput("deletedAddressIds", null, ["id" => "deletedAddressIds"]); ?>
        <?php foreach ($model->addresses as $i => $model): ?>
            <? /** @var $model Address */ ?>
            <div class="addresses-item col-md-12">
                <?php
                if (!$model->isNewRecord) {
                    echo "<div style='display: none;'>";
                    echo Html::activeHiddenInput($model, "[{$i}]id");
                    echo Html::hiddenInput("oldModelsIds[]", $model->id);
                    echo "</div>";
                }
                ?>
                <div class="row">
                    <div class="col-md-4">
                        <?= $form->field($model, "[{$i}]country")->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, "[{$i}]city")->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, "[{$i}]street")->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <?= $form->field($model, "[{$i}]house_number")->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, "[{$i}]office_number")->textInput() ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, "[{$i}]post_index")->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-11">
                        <div class="remove-item btn btn-danger" data-item-id="<?= $model->isNewRecord ? 0 : $model->id ?>">Удалить</div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="row">
        <div class="add-item btn btn-info col-md-offset-3 col-md-6">Добавить</div>
    </div>

    <?php DynamicFormWidget::end() ?>

    <?php ActiveForm::end(); ?>

</div>
