<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "usuarios_datos".
 *
 * @property int $user_id
 * @property string $aficiones
 * @property string $tematica_favorita
 * @property string $plataforma
 * @property string $pagina_web
 * @property string $avatar
 * @property int $tipo_usuario
 *
 * @property TiposUsuario $tipoUsuario
 * @property User $user
 */
class UsuariosDatos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuarios_datos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'default', 'value' => null],
            [['tipo_usuario'], 'default', 'value' => 1],
            [['user_id', 'tipo_usuario'], 'integer'],
            [['aficiones', 'tematica_favorita', 'plataforma', 'pagina_web', 'avatar'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['tipo_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => TiposUsuario::className(), 'targetAttribute' => ['tipo_usuario' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'aficiones' => 'Aficiones',
            'tematica_favorita' => 'Temática Favorita',
            'plataforma' => 'Plataforma',
            'pagina_web' => 'Página Web',
            'avatar' => 'Avatar',
            'tipo_usuario' => 'Tipo de usuario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoUsuario()
    {
        return $this->hasOne(TiposUsuario::className(), ['id' => 'tipo_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return User::findOne($this->user_id);
    }

    /**
     * Devuelve el nombre del usuario.
     * @return string Nombre de usuario.
     */
    public function getName()
    {
        return User::findOne($this->user_id)->username;
    }

    /**
     * Devuelve un array para formar la url de "Mi Perfil".
     * @return array
     */
    public function getMiPerfil()
    {
        return ['usuarios-completo/view', 'username' => $this->getName()];
    }
}