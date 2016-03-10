<?php

    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
    use frontend\models\Country;
    use frontend\models\Comment_writer;
    use frontend\models\CommentForm;
    use yii\helpers\ArrayHelper;
    use yii\widgets\LinkPager;
    //use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    use yii\widgets\MaskedInput;

    $this->title = 'Comments';
    $this->params['breadcrumbs'][] = $this->title;
?>

<?php if (Yii::$app->session->hasFlash('messageAdded')): ?>
    <p class="alert alert-success">New message has been added successfully!</p>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('messageUpdated')): ?>
    <p class="alert alert-success">The message has been updated successfully.</p>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('messageArchived')): ?>
    <p class="alert alert-success">The task has been archived.</p>
<?php endif; ?>

<div class="site-signup">

    <h1><?= $formSubTitle; ?></h1>

    <p>Please fill in the following fields to add message/comment:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($commentForm, 'comment_writer')->textInput() ?>

            <?= $form->field($commentForm, 'comment_subject')->textInput() ?>

            <?= $form->field($commentForm, 'comment_w_email') ?>

            <?= $form->field($commentForm, 'comment_w_phone')->widget(MaskedInput::className(), [
                 'mask' => '(999)999-99-99',
                ]) ?>

            <?= Html::activeDropDownList($commentForm, 'country', ArrayHelper::map(array_merge(['0'=>['country_id'=> '0','country_name' => 'Select your country']],Country::find()->all()), 'country_id', 'country_name')) ?>


            <?= $form->field($commentForm, 'comment_w_gender')->inline()->
            radioList(['M'=>'Male','F'=>'Female'], ['options' =>['unselect' => false]]); ?>

            <?= $form->field($commentForm, 'comment_message')->textarea( $options = ['placeholder' => 'Оставьте Ваше сообщение...']) ?>

            <div class="form-group">
                <?= Html::submitButton('Send message', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>



    </div>

    <h1><?= $commentsOutputSubTitle; ?></h1>
    <div class="row">
        <?php if (isset($allComments)): ?>
            <?php foreach($allComments as $comment):?>
                <div class="col-md-8">
                    <ul>
                        <li><h3><?= $comment['comment_subject']; ?></h3></li>
                        <li><?= $comment['comment_message']; ?></li>
                    </ul>

                </div>
                <div class="col-md-84">
                    <ul>
                        <li><h4>Message added by:</h4></li>
                        <li>Name: <?= $comment['comment_writer']; ?></li>
                        <li>From: <?= $comment['country_name']; ?></li>
                        <li>Email: <?= $comment['comment_w_email']; ?></li>
                        <li>Date: <?= date("Y.m.d H:s", $comment['comment_date_created']) ?></li>
                        <li><a title="Delete message" href="<?= Url::to(['comment/archive', 'id' => $comment['comment_id']]) ?>">Delete</a></li>
                        <li><a title="Edit message" href="<?= Url::to(['comment/edit', 'id' => $comment['comment_id']]) ?>">Edit</a></li>
                    </ul>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p><?php echo 'No comments added.';?></p>
        <?php endif; ?>
    </div>
