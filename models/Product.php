<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property string $image
 * @property string $name
 * @property integer $price
 * @property integer $product_id
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    public $imageFiles;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'integer'],
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['image', 'name'], 'string', 'max' => 255],
            [['name', 'price',], 'required'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->imageFiles->saveAs('uploads/' . $this->imageFiles->baseName . '.' . $this->imageFiles->extension);
            $this->image = $this->imageFiles->baseName . '.' . $this->imageFiles->extension;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'image' => 'Image',
            'imageFiles' => 'Image',
            'name' => 'Name',
            'price' => 'Price',
            'product_id' => 'Product ID',
        ];
    }
}
