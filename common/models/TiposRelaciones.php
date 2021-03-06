<?php

namespace common\models;

/**
 * This is the model class for table "tipos_relaciones".
 *
 * @property int $id
 * @property string $tipo
 *
 * @property Relaciones[] $relaciones
 */
class TiposRelaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipos_relaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo_es', 'tipo_en'], 'required'],
            [['tipo', 'tipo_en'], 'string', 'max' => 255],
            [['tipo', 'tipo_en'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo_es' => 'Tipo',
            'tipo_en' => 'Type'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelaciones()
    {
        return $this->hasMany(Relaciones::className(), ['tipo_relacion_id' => 'id']);
    }
}
