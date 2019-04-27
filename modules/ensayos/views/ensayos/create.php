<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\clientes\models\Clientes */

$this->title = 'Registrar Cliente';
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clientes-create">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
