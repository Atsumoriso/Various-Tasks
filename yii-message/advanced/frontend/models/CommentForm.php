<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db;
use yii\db\ActiveRecord;



/**
 * This is Comment form
 */
class CommentForm extends Model
{
    /*Attributes we receive from the form*/
    public $comment_writer;
    public $comment_w_email;
    public $comment_w_phone;
    public $comment_w_gender;
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
            [['comment_writer', 'comment_w_email', 'comment_subject', 'comment_message', 'country'], 'required'],

            [['comment_writer','comment_w_email','comment_subject'], 'filter','filter'=>'trim'],
            // email has to be a valid email address
            ['comment_w_email', 'email'],
            /*  validation for number of symbols*/
            //['name' ,'match', 'pattern' => "/^{3,}+$/i"],
            //['subject' ,'match', 'pattern' => "/^{5,}+$/i"],
            //[['message'], 'string', 'min' => 20],

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
            'comment_country_id' => 'Country of residence',
            'comment_w_gender' => 'Gender',
            'comment_subject' => 'Subject',
            //'verifyCode' => 'Verification Code',
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




}
