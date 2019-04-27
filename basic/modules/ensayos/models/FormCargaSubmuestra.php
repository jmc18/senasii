<?php
namespace app\modules\ensayos\models;

use Yii;
use yii\base\model;

class FormCargaSubmuestra extends model {
    public  $idarea, $idref, $idcot, $no_submuestra, $idunidad, $resultado, $fecha_captura;
    
    public function rules(){
        return [
            ['resultado', 'required', 'Obligatorio'],
            ['idunidad', 'required', 'Obligatorio'],
            [['idunidad'], 'exist', 'skipOnError' => true, 'targetClass' => UnidadesResultados::className(), 'targetAttribute' => ['idunidad' => 'idunidad']],
        ];
    }
    
}
