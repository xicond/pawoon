<?php

use app\models\Product;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS

$("document").ready(function(){ 
        $("#_form_product_create").on("pjax:end", function(e) {
            e.preventDefault();
            $.pjax.reload({container:"#_list_product"});  //Reload GridView
        });
                
        $(document).on('click', "#_list_product td>a[title=Update]", function (e) {
            //request data ajax
            e.preventDefault();
            $.pjax.reload({url: $(this).attr('href'), container:"#_form_product_update"});
            $('#_modal_edit').modal();
            
        });
    });
    
JS;
$this->registerJs($script);

?>
<div class="product-index">

    <h1><?= Html::encode('Product List') ?></h1>

    <div>
        <?php
        Modal::begin([
//            'header' => '<h5>Add Product</h5>',
            'toggleButton' => ['label' => 'Create Product', 'class' => 'btn btn-success'],
        ]);

        ?>
        <div class="product-create">

            <h1><?= Html::encode('Add Product') ?></h1>

            <?= $this->render('_form', [
                'model' => new Product(),
                'action' => ['create'],
            ]) ?>

        </div>

        <?php

        Modal::end();

        ?>
    </div>
    <?php \yii\widgets\Pjax::begin(['id' => '_list_product']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'image',
                'format' => 'html',
                'value' => function($data) { return $data->image?Html::img('uploads/'.$data->image, ['width'=>'100']):''; },
            ],
            'name',
            'price',
//            'product_id',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>

    <?php
    if($dataProvider->count)
    Modal::begin([
//            'header' => '<h5>Add Product</h5>',
//        'toggleButton' => ['label' => 'Create Product', 'class' => 'btn btn-success'],
            'id' => '_modal_edit'
    ]);

    ?>
    <div class="product-update">

        <h1><?= Html::encode('Edit Product') ?></h1>

        <?= $this->render('_form', [
            'model' => $dataProvider->models[0],
            'action' => ['update'],
        ]) ?>

    </div>

    <?php

    Modal::end();

    ?>
</div>
