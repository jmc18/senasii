<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\SideNav;

$this->title = 'Catálogos';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
echo SideNav::widget([
  'type' => SideNav::TYPE_DEFAULT,
  'heading' => 'Gestión de Catálogos',
  'items' => [
    [
      'url' => Url::to(['catalogos/ramas']),
      'label' => 'Ramas',
      'icon' => 'certificate'
    ],
    [
      'url' => Url::to(['catalogos/subramas']),
      'label' => 'Subramas',
      'icon' => 'certificate',
    ],
    [
      'url' => Url::to(['catalogos/areas']),
      'label' => 'Areas',
      'icon' => 'certificate'
    ],
    [
      'url' => Url::to(['catalogos/analitos']),
      'label' => 'Analitos',
      'icon' => 'certificate'
    ],
    [
      'url' => Url::to(['catalogos/referencias']),
      'label' => 'Referencias',
      'icon' => 'certificate'
    ],
  ],
]);

?>