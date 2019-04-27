<?php
  use yii\helpers\Url;
  use yii\helpers\Html;
  use yii\bootstrap\ActiveForm;
  use kartik\widgets\SideNav;
?>

<?php
echo SideNav::widget([
  'type' => SideNav::TYPE_DEFAULT,
  'heading' => 'Gestión de Calendarios',
  'items' => [
    [
      'url' => Url::to(['calendarios/calibracion']),
      'label' => 'Calendario Calibración',
      'icon' => 'calendar'
    ],
    [
      'url' => Url::to(['calendarios/internacional']),
      'label' => 'Calendario Internacional',
      'icon' => 'calendar',
    ],
    [
      'url' => Url::to(['calendarios/calendario','norama'=>1]),
      'label' => 'Calendario Agua',
      'icon' => 'calendar'
    ],
    [
      'url' => Url::to(['calendarios/calendario','norama'=>2]),
      'label' => 'Calendario Alimentos',
      'icon' => 'calendar'
    ],
  ],
]);
?>



    