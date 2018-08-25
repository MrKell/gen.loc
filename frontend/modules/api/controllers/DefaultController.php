<?php

namespace frontend\modules\api\controllers;



use Yii;
use yii\web\Controller;
use app\models\Clients;
use app\models\Phones;



/**
 * Default controller for the `api` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */

    protected static $redis_max = 10;

    public function beforeAction($action)
    {            
        if ($action->id == 'index') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }


    public function actionIndex()
    {
        $json = Yii::$app->getRequest()->getRawBody();
        $data = json_decode($json, true);
        $redis = Yii::$app->redis;

        //$this->DbInsert($redis->keys('*'), $redis);


        //Проверяем сколько записей в Redis
        if($redis->dbsize() < self::$redis_max){
            if(empty($data['firstName']) && empty($data['firstName']) ){
                return 'Ошибка, не все параметры переданы.';
            }else{
                $new_key = $data['firstName'].'_'.$data['lastName'];
                $redis->set($new_key, $json);
                return 'Redis ';
            }            
        }else{

            $this->DbInsert($redis->keys('*'), $redis);
            $redis->flushall();
            return 'Save to Db';
        }

       die();
    }

    private function DbInsert(array $keys, $redis){

        foreach($keys as $key=>$value){
            $row = json_decode($redis->get($value), true);

            $client = new Clients();

            $client->first_name = $row['firstName'];
            $client->last_name = $row['lastName'];

            if($client->save()){


                foreach ($row['phoneNumbers'] as $key2=>$number){
                    $phone = new Phones();
                    $phone->user_id = $client->id;
                    $phone->phone = $number;
                    $phone->save();
                }


            }else{
                return 'error';
            }

        }

    }

}
