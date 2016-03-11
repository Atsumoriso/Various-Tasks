<?php

    namespace frontend\models;

    use Yii;
    use yii\base\Model;
    use yii\db;
    use yii\db\ActiveQuery;
    use yii\db\ActiveRecord;



    /**
     * This is Comment Update Form  for editing comments
     */
    class CommentUpdateForm extends Model
    {
        /*Attributes to update in the form*/

        public $comment_writer;
        public $comment_w_email;
        public $comment_w_phone;
        public $comment_w_gender;

        public $comment_subject;
        public $comment_message;
        public $country;
        public $comment_country_id;

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
            $this->comment_w_phone = $this->comment_to_update['comment_w_phone'];
            $this->comment_w_gender = $this->comment_to_update['comment_w_gender'];
            $this->comment_country_id = $this->comment_to_update['comment_country_id'];


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
                [['comment_writer', 'comment_w_email', 'comment_subject', 'comment_message'], 'required'],

                ['country', 'required', 'message' => 'Please, make your choice'],

                [['comment_writer','comment_w_email','comment_subject' ], 'filter','filter'=>'trim'],

                // email has to be a valid email address
                ['comment_w_email', 'email', 'message' => 'E-mail should be in the format name@example.com'],

                /*  validation for number of symbols*/
                ['comment_writer', 'string', 'min' => 3, 'max' => 255, 'message' => 'Name should contain at least 3 characters'],
                ['comment_subject', 'string', 'min' => 5, 'max' => 255, 'message' => 'Subject should contain at least 5 characters'],
                ['comment_w_phone', 'integer', 'min' => 5, 'message' => 'Phone should contain figures only and not less than 5'],
                ['comment_message', 'string', 'min' => 20, 'message' => 'Message should contain at least 20 characters'],

                ['comment_w_gender', 'required']
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
                'comment_w_phone' => 'Your phone',
                'comment_w_gender' => 'Gender',
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
                $comment->comment_w_phone = $this->comment_w_phone;
                $comment->comment_w_gender = $this->comment_w_gender;
                $comment->comment_country_id = $this->country;
                $comment->comment_subject = $this->comment_subject;
                $comment->comment_message = $this->comment_message;
                $comment->save();
                return true;
            }
            return false;
        }


        //этот метод можно и отсюда вызвать, а не с контроллера, и сделать контроллер тоньше:)
//        public function findModel($id)
//        {
//            return $comment = Comment::find()->where(['comment_id'=> $id])->asArray()->one();
//        }



    }