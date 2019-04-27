<?php
  use yii\helpers\Url;
  use yii\helpers\Html;
  use yii\bootstrap\ActiveForm;
  use kartik\widgets\SideNav;

  $this->title = 'Seleccionar Ensayos';
  $this->params['breadcrumbs'][] = $this->title;
?>

    <div class="row">
      <div class="col-xs-12">
        <?php
          echo SideNav::widget([
            'type' => SideNav::TYPE_DEFAULT,
            'heading' => 'Calendarios de Calibración',
            'items' => [
              [
                'url' => Url::to(['ensayos/solicitarcalibracion']),
                'label' => 'Calendario Calibración',
                'icon' => 'dashboard'
              ],
              [
                'url' => Url::to(['ensayos/solicitarinternacional']),
                'label' => 'Calendario Internacional',
                'icon' => 'globe',
              ],
              [
                'url' => Url::to(['ensayos/solicitargeneral','norama'=>1]),
                'label' => 'Calendario Agua',
                'icon' => 'tint'
              ],
              [
                'url' => Url::to(['ensayos/solicitargeneral','norama'=>2]),
                'label' => 'Calendario Alimentos',
                'icon' => 'grain'
              ],
            ],
          ]);
        ?>
      </div>
    </div>