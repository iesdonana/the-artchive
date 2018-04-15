<?php
namespace frontend\models;

use Yii;

use yii\base\Model;
use common\models\User;
use common\models\Personajes;
use common\models\Seguidores;
use common\models\Publicaciones;
use common\models\UsuariosDatos;
use common\models\Notificaciones;
use common\models\MensajesPrivados;

/**
 * Signup form
 */
class DeleteAccountForm extends Model
{
    public $username;
    public $personajes;
    public $publicaciones;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'compare', 'compareValue' => (Yii::$app->user->identity->username), 'message' => 'El nombre de usuario no coincide.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            [['personajes', 'publicaciones'], 'string'],
            [['personajes', 'publicaciones'], 'in', 'range' => ['0', '1']],
        ];
    }

    public function desactivarUsuario()
    {
        $model = $this->getUser();
        $model->username = '--' . $model->id . '--';
        $model->email = Yii::$app->security->generateRandomString();
        $model->status = 0;

        $this->username = $model->username;

        return $model->save();
    }

    public function borrarTodo()
    {
        $this->borrarPjs();
        $this->borrarPublicaciones();
        $this->borrarRastro();
    }

    public function borrarPjs()
    {
        $model = $this->getUser();
        if ($this->personajes) {
            Publicaciones::deleteAll(['usuario_id' => $model->id]);
        }
    }

    public function borrarPublicaciones()
    {
        $model = $this->getUser();
        if ($this->personajes) {
            Personajes::deleteAll(['usuario_id' => $model->id]);
        }
    }

    public function borrarRastro()
    {
        $id = $this->getUser()->id;
        $datos = UsuariosDatos::findOne($id);
        $datos->delete();
        Seguidores::deleteAll(['user_id' => $id]);
        Seguidores::deleteAll(['seguidor_id' => $id]);
        MensajesPrivados::updateAll(['del_e' => true], 'emisor_id = ' . $id);
        MensajesPrivados::updateAll(['del_r' => true], 'receptor_id = ' . $id);
        Notificaciones::deleteAll(['user_id' => $id]);
    }

    public function getUser()
    {
        return User::findOne(['username' => $this->username]);
    }
}
