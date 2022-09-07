<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\httpclient\Client;

class SiteController extends Controller
{
    private $errorMessage = "";
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
            ->send();
        if ($response->isOk) {
            $eventNames = $response->data;
        }
        
        return $eventNames;
    }

    private function listEvents(){
        $events = [];

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl('http://127.0.0.1:8000/api/events')
            ->send();
        if ($response->isOk) {
            $events = $response->data;
        }
        
        return $events;
    }

    private function listEventsOrdered(){
        $events = [];

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl('http://127.0.0.1:8000/api/eventsordered')
            ->send();
        if ($response->isOk) {
            $events = $response->data;
        }
        
        return $events;
    }

    private function listLastEventDevice(){
        $events = [];

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl('http://127.0.0.1:8000/api/lasteventdevice')
            ->send();
        if ($response->isOk) {
            $events = $response->data;
        }
        
        return $events;
    }

    public function actionIndex()
    {
        $eventNames = $this->listEventName();
        $events = $this->listEvents();
        $eventsOrdered = $this->listEventsOrdered();
        $lastEventDevices = $this->listLastEventDevice();

        return $this->render('index', ['eventNames' => $eventNames,
        'events' => $events,
        'eventsOrdered' => $eventsOrdered,
        'lastEventDevices' => $lastEventDevices,
        'errorMessage' => $this->errorMessage],
        );
    }

    public function actionSave(){
        $eventNameId = Yii::$app->request->post('eventNameId');
        $id = Yii::$app->request->post('id');
        $device = Yii::$app->request->post('device');
        $time = Yii::$app->request->post('time');

        $saveResponse['name'] = "None";
        if ($device != ""){
            if ($id == ""){
                $client = new Client();
                $response = $client->createRequest()
                    ->setMethod('POST')
                    ->setFormat(Client::FORMAT_JSON)
                    ->setUrl('http://127.0.0.1:8000/api/saveevent')
                    ->setData(['device' => $device, 'event_name_id'=> $eventNameId, 'time'=>$time])
                    ->send();
            }
            if ($response->isOk) {
                $saveResponse = $response->data;
            } else {
                $this->errorMessage = "That action isn't allowed.";
            }
        }

        return $this->actionIndex();
    }
}
