<?php

/**
 * This is the model class for table "faq".
 *
 * The followings are the available columns in table 'faq':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $site
 * @property string $question
 * @property string $answer
 * @property integer $answered
 * @property integer $published
 * @property string $create_at
 */
class Faq extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'faq';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, question', 'required'),
			array('answered, published, cid', 'numerical', 'integerOnly'=>true),
			array('answer, question, name, email, phone', 'type', 'type'=>'string'),
         array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
         array('cid', 'default', 'value' => '0', 'setOnEmpty' => true, 'on' => 'insert'),
			array('name, question, answer, answered, published, phone', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
         return array(
            'cat' => array(self::BELONGS_TO, 'FaqCats', 'cid'),
         );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Имя',
			'email' => 'E-mail',
			'phone' => 'Номер телефона',
			'question' => 'Вопрос',
			'answer' => 'Ответ',
			'answered' => 'Наличие ответа',
			'published' => 'Статус',
			'create_at' => 'Создано',
			'cid' => 'Раздел',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search($cid)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('cid',$cid, true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('question',$this->question,true);
		$criteria->compare('answer',$this->answer,true);
		$criteria->compare('answered',$this->answered);
		$criteria->compare('published',$this->published);
		$criteria->compare('create_at',$this->create_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
         'pagination'=>array(
            'pageSize'=>10,
         ),
         'sort'=>array(
             'defaultOrder'=>array(
              'create_at'=>"DESC"
         ))
		));
	}

   protected function beforeSave()
   {
      if(parent::beforeSave()){
         if($this->answer)
            $this->answered = 1;
         else
            $this->answered = 0;
         return True;
      } else {
         return False;
      }
   }
   
   public static function getCount($cid = 0) {
      return " (".self::model()->count("cid = '0'").")";
   }
   
	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'Published' => array(
				'0' => 'Не опубликовано',
				'1' => 'Опубликовано',
			),			
         'Answered' => array(
				'0' => 'Без ответа',
				'1' => 'Отвечено',
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}
   
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Faq the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}