<?php

    namespace frontend\models;

    use Yii;
    use yii\base\Model;
    use yii\db;
    use yii\db\ActiveQuery;
    use yii\db\ActiveRecord;



    /**
     * This is Comment Update Form  for comments
     */
    class CommentUpdateForm extends Model
    {
        /*Attributes to update in the form*/

        public $comment_writer;
        public $comment_w_email;
        public $comment_subject;
        public $comment_message;

        /*Attributes that were in the DB*/
        public $comment_id;// int
        public $comment_to_update; //array

        public function __construct($comment_id, $arr)
        {
            $this->comment_id = $comment_id;
            $this->comment_to_update = $arr;//$this->findModel($this->comment_id);

            //if($this->comment_to_update['comment_writer']!=null){
            $this->comment_writer = $this->comment_to_update['comment_writer'];
            //}
            $this->comment_w_email = $this->comment_to_update['comment_w_email'];
            $this->comment_subject = $this->comment_to_update['comment_subject'];
            $this->comment_message = $this->comment_to_update['comment_message'];

        }


        /**
         * Sets up rules for validation
         * @inheritdoc
         */
        public function rules()
        {
            return [
                // name, email, subject and body are required
                [['comment_writer', 'comment_w_email', 'comment_subject', 'comment_message'], 'required'],

                [['comment_writer','comment_w_email','comment_subject'], 'filter','filter'=>'trim'],
                // email has to be a valid email address
                ['comment_w_email', 'email'],
            ];
        }

        /**
         * Sets up Labels
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'comment_writer' => 'Your name',
                'comment_w_email' =>'Your email',
                'comment_subject' => 'Subject',
                'comment_message' => 'Message',
                //'verifyCode' => 'Verification Code',
            ];
        }


        /**
         * If validation is ok, gets POST data and updates data in DB
         * @param $id
         * @return bool
         */
        public function updateComment($id)
        {
            if ($this->validate()) {
                $comment = Comment::findOne($id);
                $comment->comment_writer = $this->comment_writer;
                $comment->comment_w_email = $this->comment_w_email;
                $comment->comment_subject = $this->comment_subject;
                $comment->comment_message = $this->comment_message;
                $comment->save();

                return true;
            }
            return false;
        }

//        public function findModel($id)
//        {
//            return $comment = Comment::find()->where(['comment_id'=> $id])->asArray()->one();
//        }



    }