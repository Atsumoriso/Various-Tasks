<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db;




/**
 * This is Comment form
 */
class CommentForm extends Model
{
    /*Attributes we receive from the form*/
    public $comment_writer;
    public $comment_w_email;
    public $comment_w_phone;
    public $comment_w_gender = 'M';//checked value!
    public $comment_country_id;
    public $country;

    public $comment_subject;
    public $comment_message;
    public $comment_date_created;
    //public $mask;

    /**
     * Sets up rules for validation
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['comment_writer', 'comment_w_email', 'comment_subject', 'comment_message'], 'required'],

            ['country', 'required', 'message' => 'Please, make your choice'],

            [['comment_writer','comment_w_email','comment_subject'], 'filter','filter'=>'trim'],

            // email has to be a valid email address
            ['comment_w_email', 'email', 'message' => 'E-mail should be in the format name@example.com'],

            /*  validation for number of symbols*/
            ['comment_writer', 'string', 'min' => 3, 'max' => 255, 'message' => 'Name should contain at least 3 characters'],
            ['comment_subject', 'string', 'min' => 5, 'max' => 255, 'message' => 'Subject should contain at least 5 characters'],
            ['comment_w_phone', 'integer', 'min' => 5, 'message' => 'Phone should contain figures only and not less than 5'],
            ['comment_message', 'string', 'min' => 20, 'message' => 'Message should contain at least 20 characters'],

            ['comment_w_gender', 'required'],



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
            'comment_w_phone' => 'Your phone',
            'country' => 'Country of residence',
            'comment_w_gender' => 'Gender',
            'comment_subject' => 'Subject',
            'comment_message' => 'Your message',
        ];
    }


    /**
     * If validation is ok, gets POST data and saves to DB
     * @return bool
     */
    public function addComment()
    {

        if($this->validate()){
            $comment = new Comment;
            $comment->comment_writer = $this->comment_writer;
            $comment->comment_w_email = $this->comment_w_email;
            $comment->comment_w_phone = $this->comment_w_phone;
            $comment->comment_w_gender = $this->comment_w_gender;
            $comment->comment_country_id = $this->country;

            $comment->comment_subject = $this->comment_subject;
            $comment->comment_message = $this->comment_message;
            $comment->comment_date_created = time();

            $comment->save();
            return true;
        }
        return false;
    }

    public function getPostData()
    {
        //return $res = Yii::$app->request->post();
        $request = Yii::$app->request;
        $res = $request->getBodyParams;
        return $res; //= $request->getBodyParam('comment_writer');
    }

    public function getName()
    {
        return $this->comment_writer;
    }


}
