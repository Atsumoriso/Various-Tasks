<?php
     /**
     * This is the class for `country` table
     */

    namespace frontend\models;

    use Yii;
    use yii\db;
    use yii\db\ActiveRecord;

    class Country extends ActiveRecord
    {
        public static function tableName()
        {
            return 'country';
        }

        /**
         * Establishing hasOne relation with Comment table
         * @return \yii\db\ActiveQuery
         */
        public function getComment()
        {
            return $this->hasMany(Comment::classname(), ['comment_country_id' => 'country_id']);/*Сначала ключ другой таблицы, потом своей*/
        }
    }