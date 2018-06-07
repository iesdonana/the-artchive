<?php

namespace frontend\controllers;

use Yii;
use yii\data\Pagination;

use yii\filters\AccessControl;

use common\models\User;
use common\models\Comentarios;
use common\models\Publicaciones;
use common\models\PublicacionesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PublicacionesController implements the CRUD actions for Publicaciones model.
 */
class PublicacionesController extends Controller
{
    use \common\utilities\Permisos;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => $this->paramByPost(['delete']),
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    $this->mustBeLoggedForAll(),
                    $this->mustBeMyContent(['update', 'delete']),
                ],
            ],
        ];
    }

    /**
     * Lists all Publicaciones models.
     * @param  string $username Nombre de usuario del propietario de
     * las publicaciones.
     * @return mixed
     */
    public function actionIndex($username)
    {
        $user = User::findOne(['username' => $username]);

        if ($user) {
            $id = $user->id;
        }
        if (isset($id)) {
            $searchModel = new PublicacionesSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            $dataProvider->query->where(['usuario_id' => $id]);


            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single Publicaciones model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $query = Comentarios::find()
        ->select('co.*, count(co.id) as quoted, uc.username, uc.avatar')
        ->from('comentarios co')
        ->joinWith('comentarios qu')
        ->join('join', 'usuarios_completo uc', 'uc.id = co.usuario_id')
        ->where(['co.publicacion_id' => $id, 'co.comentario_id' => null])
        ->groupBy('co.id, uc.username, uc.avatar')
        ->orderBy('co.created_at DESC');

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->setPageSize(5);
        $comentarios = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'comentarios' => $comentarios,
            'pagination' => $pages,
        ]);
    }

    /**
     * Creates a new Publicaciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Publicaciones();
        $model->usuario_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Publicaciones model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Publicaciones model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/usuarios-completo/view', 'username' => Yii::$app->user->identity->username]);
    }

    /**
     * Finds the Publicaciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Publicaciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Publicaciones::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'La página requerida no existe.'));
    }
}
