<?php
    /**
     * This is the class for `comment` table
     */

    namespace frontend\models;

    use Yii;
    use yii\base\Model;
    use yii\db;
    use yii\db\ActiveRecord;

    class Comment extends ActiveRecord
    {

        public static function tableName()
        {
            return 'comment';
        }

        /**
         * Establishing hasOne relation with Country table
         * @return \yii\db\ActiveQuery
         */
        public function getCountry()
        {
            return $this->hasOne(Country::classname(), ['country_id' => 'comment_country_id']);/*Сначала ключ другой таблицы, потом своей === или сначала ключ таблицы, которую пишем после hasOne hasMany*/
        }


        /**
         * Returns query for all comments to display
         * @return array|db\ActiveRecord[] - array of objects
         */
        public function getAllComments()
        {

            // работает, кроме вывода страны
//            $allComments = Comment::find()
//                //->joinWith('country')
//                ->join(
//                    'INNER JOIN',
//	                'country',
//	                'country.country_id = comment.comment_country_id'
//                )
//                ->select(['comment_id', 'comment_writer', 'comment_w_email', 'comment_date_created', 'comment_subject', 'comment_message', 'comment_is_archived', 'country.country_name', 'comment_w_phone'])
//                ->where(['comment_is_archived' => 0])
//                ->orderBy(['comment_date_created' => SORT_DESC])
//                ->all();

            //variant #2 работает на 100%, разница - выше делается массив объектов, ниже - обычный массив!
            $db = Yii::$app->db;
            $allComments = $db
                ->createCommand(
                    'SELECT * FROM `comment` c
                      JOIN `country` on c.comment_country_id=country.country_id
                      WHERE comment_is_archived = 0
                      ORDER BY comment_date_created DESC')
                ->queryAll();



            return $allComments;
        }


        /**
         * Archives comment by id (comment will become hidden)
         * @param $id
         * @throws db\Exception
         */
        public function archiveComment($id)
        {
            $db = Yii::$app->db;
            $db->createCommand('UPDATE `comment` SET comment_is_archived = 1 WHERE comment_id= (:id)', [
                ':id' => $id,
            ])->execute();
            // to delete message: DELETE FROM `comment` WHERE
        }


        /**
         * Change Unix date format from DB to usual date format
         * @return bool|string
         */
        public function getDate()
        {
            return date('Y-m-d H:i', $this->comment_date_created);
        }

        /**
         * Gets model to further update
         * @param $id
         * @return array|null|ActiveRecord
         */
        public function findModel($id)
        {
            return $comment = Comment::find()->where(['comment_id'=> $id])->asArray()->one();
        }



    }

