<?php
use app\models\Call;
use app\models\Customer;
use app\models\History;
use app\models\search\HistorySearch;
use app\models\Sms;
use app\widgets\HistoryList\helpers\HistoryListHelper;
use yii\helpers\Html;

/** @var $model HistorySearch */

echo HistoryListHelper::getRender($model->event)->render($this, $model);
