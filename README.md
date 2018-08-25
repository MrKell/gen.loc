<h1>Тестовое задание для Genesis</h1>

<h2>Требования</h2>
<ul>
    <li>Redis 3.2</li>
</ul>


<h2>Установка</h2>
<ul>
    <li>Необходимо запустить миграцию init</li>
</ul>

<h2>API</h2>
<ul>
    <li>Запрос методом POST на http://gen.loc/frontend/web/index.php?r=api</li>
    <li>Набирается очередь в Redis когда очедь больше максимума - пишется в базу</li>
    <li>За размер очереди отвечает свойство $redis_max в frontend\modules\api\controllers\DefaultController.php</li>
</ul>

<h2>Список записей</h2>
<ul>
    <li>Вид http://gen.loc/frontend/web/index.php?r=clients</li>
</ul>
