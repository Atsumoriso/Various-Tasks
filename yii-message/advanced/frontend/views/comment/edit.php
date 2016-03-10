<?php

    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
    use yii\helpers\ArrayHelper;
    use frontend\models\Country;


    $this->title = 'Edit message';
    $this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'form-signup' /*, 'action' => 'comment/update'*/]); ?>

        <?= $form->field($commentForm, 'comment_writer')->textInput() ?>

        <?= $form->field($commentForm, 'comment_w_email') ?>

        <?= $form->field($commentForm, 'comment_w_phone')->textInput() ?>

        <?= $form->field($commentForm, 'country')->DropDownList(ArrayHelper::map(array_merge(Country::find()->all()), 'country_id', 'country_name'), ['prompt' => 'Select your country']) ?>

        <?= $form->field($commentForm, 'comment_subject')->textInput() ?>

        <?= $form->field($commentForm, 'comment_message')->textarea() ?>

        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>