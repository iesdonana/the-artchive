<?php
use yii\widgets\LinkPager;
use common\models\Comentarios;

?>
<h3><?= Yii::t('frontend', 'Comentarios') ?></h3>
<div id="publicacion-comentarios">
    <?php foreach ($comentarios as $comentario) : ?>
        <?= $this->render('_comentario', [
            'comentario' => $comentario,
            'publicacion' => $publicacion,
            'respuesta' => false,
            ]) ?>
    <?php endforeach; ?>
    <?= LinkPager::widget([
        'pagination' => $pagination,
    ]);
    ?>
</div>
<div id="nuevo-comentario">
    <h3><?= Yii::t('frontend', 'Publicar comentario') ?></h3>
    <div class="nuevo-comentario">
        <?= $this->render('_responder', [
            'model' => new Comentarios(),
            'publicacion' => $publicacion,
            'comentario' => false,
        ]) ?>
    </div>
</div>