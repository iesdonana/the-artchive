<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use frontend\models\DeleteAccountForm;

class DeleteAccountController extends Controller
{
    use \common\utilities\Permisos;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    $this->mustBeLoggedForAll(),
                ],
            ],
        ];
    }

    /**
     * Abre la ventana para gestionar la baja del usuario, y desde ahí la gestiona.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new DeleteAccountForm();

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Da de baja la cuenta actual.
     */
    public function actionDelete()
    {
        $model = new DeleteAccountForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->borrarTodo();
            if ($model->desactivarUsuario()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('frontend', 'Se ha dado de baja satisfactoriamente.'));
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t('frontend', 'No se pudo dar de baja.'));
            }
            return $this->goHome();
        }
    }
}
