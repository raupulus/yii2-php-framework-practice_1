<?php

namespace app\controllers;

use DateTime;
use function range;
use function var_dump;
use Yii;
use app\models\Citas;
use app\models\CitasSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CitasController implements the CRUD actions for Citas model.
 */
class CitasController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Citas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CitasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Citas model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Citas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $citas = Citas::find();
        $usuario_id = Yii::$app->user->id;
        $hoy = new DateTime('now');

        $n_citas = $citas->where([
            'usuario_id' => $usuario_id,
        ])
        ->andWhere([
            '>=', 'fecha', $hoy->format('Y/m/d'),
        ])
        ->count();

        /* Si tiene una cita devuelve un mensaje y devuelve a citas/index */
        if ($n_citas >= 1) {
            Yii::$app->session->setFlash(
                'error',
                'Solo puedes tener 1 cita pendiente de asistencia, por favor 
                cancela la cita existente primero'
            );
            return $this->redirect(['index']);
        }

        /* Busco la última cita */
        $ultima_cita = Citas::find()->orderBy(
            'fecha DESC, hora DESC'
        )->one();

        /* Creo DateTime con la última fecha y hora */
        $fecha_ultima = new DateTime($ultima_cita->fecha);
        $fecha_ultima->setTime(
            date('H', strtotime($ultima_cita->hora)),
            date('i', strtotime($ultima_cita->hora)),
            '00'
        );

        /* Creo intervalo de tiempo (En principio no necesario)*/
        //$horas_validas = range(10, 21);
        //$minutos_validos = [00, 15, 30, 45];


        // Si la última reserva es anterior a hoy se da mañana a las 10:00

        if ($hoy >= $fecha_ultima) {
            $fecha = $hoy->modify('+1 day')->format('Y/m/d');
            $hora = '10:00:00';
        } else {
            /* A la fecha y hora de la última cita aumentar 15 min */
            if ($ultima_cita->hora >= '20:45:00') {

                $fecha = $fecha_ultima->modify('+1 day')
                         ->format('Y/m/d');
                $hora = '10:00:00';
            } else {
                $fecha = $fecha_ultima->format('Y/m/d');  // YYYY/MM/DD
                $hora = $fecha_ultima->modify('+15 min')
                        ->format('H:i:s');  // HH:MM:SS
            }
        }


        $model = new Citas([
            'usuario_id' => $usuario_id,
            'fecha' => $fecha,
            'hora' => $hora,
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Citas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
     * Deletes an existing Citas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Citas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Citas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Citas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
