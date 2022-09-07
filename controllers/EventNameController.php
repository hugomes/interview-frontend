<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\httpclient\Client;
use Yii;

class EventNameController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    private function listEventName(){
        $eventNames = [];

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl('http://127.0.0.1:8000/api/eventnames')
            ->setData(['name' => 'Touch'])
            ->send();
        if ($response->isOk) {
            $eventNames = $response->data;
        }
        
        return $eventNames;
    }

    public function actionIndex()
    {
        $eventNames = $this->listEventName();

        return $this->render('index', ['eventNames' => $eventNames]);
    }

    public function actionSave(){
        $name = Yii::$app->request->post('eventname');
        $order = Yii::$app->request->post('order');
        $id = Yii::$app->request->post('id');

        $saveResponse['name'] = "None";
        if ($name != ""){
            if ($id == ""){
                $client = new Client();
                $response = $client->createRequest()
                    ->setMethod('POST')
                    ->setFormat(Client::FORMAT_JSON)
                    ->setUrl('http://127.0.0.1:8000/api/saveeventname')
                    ->setData(['name' => $name, 'order'=>$order])
                    ->send();
            } else {
                $client = new Client();
                $response = $client->createRequest()
                    ->setMethod('PUT')
                    ->setFormat(Client::FORMAT_JSON)
                    ->setUrl('http://127.0.0.1:8000/api/eventname/'.$id)
                    ->setData(['name' => $name, 'id'=> $id, 'order'=>$order])
                    ->send();
        
            }
            if ($response->isOk) {
                $saveResponse = $response->data;
            }
        }

        return $this->render('index', ['eventNames' => $this->listEventName()]);
    }
    
    public function actionDelete(){

        $id = Yii::$app->request->get('id');
        if ($id != ""){
            $client = new Client();
            $client->createRequest()
                ->setMethod('DELETE')
                ->setFormat(Client::FORMAT_JSON)
                ->setUrl('http://127.0.0.1:8000/api/eventname/'.$id)
                ->send();            
        }

        return $this->render('index', ['eventNames' => $this->listEventName()]);
    }
    
}
