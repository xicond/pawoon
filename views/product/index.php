<?php

use app\models\Product;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;


$script = <<<JS

$("document").ready(function(){ 
        $("#_form_product_create").on("pjax:end", function(e) {
            e.preventDefault();
            $.pjax.reload({container:"#_list_product"});  //Reload GridView
        });
        
        $(document).on('submit beforeSubmit', '#_form_product_create form', function (e) {
            var form = $(this);
            // return false if form still have some validation errors
            if (form.find('.has-error').length) 
            {
                return false;
            }
            var formData = new FormData(this);

            e.preventDefault();
            // submit form
            $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function (response) 
            {
                var getupdatedata = $(response).find('#_form_product_create');
                if (!getupdatedata.length) {
                    
                    $.pjax.reload({container:"#_list_product"});
                    form[0].reset();
                    $('#_popup_create').modal('toggle');
                } else
                    $('#_form_product_create').replaceWith(getupdatedata);
                //console.log(getupdatedata);
                $('#_form_product_create form').on('submit', function (e) { e.preventDefault();return false;});

            },
            error  : function () 
            {
                console.log('internal server error');
            }
            });
            return false;
         });
         $('#_form_product_create form').on('submit', function (e) { e.preventDefault();return false;});
         
         
         $(document).on('submit', '#_form_product_update form', function (e) {
            var form = $(this);
            // return false if form still have some validation errors
            //console.log('ok');
            if (form.find('.has-error').length) 
            {
                return false;
            }
            var formData = new FormData(this);
            var url = location.href;
            //console.log($(this).attr('action'),url);

            e.preventDefault();
            // return false;
            // submit form
            $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            //cache:false,
            contentType: false,
            processData: false,
            success: function (response) 
            {
                var getupdatedata = $(response).find('#_form_product_update');
                // console.log(getupdatedata,getupdatedata.find('.has-error'),url);
                // return false;
                if (!getupdatedata.find('.has-error').length) {
                    
                    $.pjax.reload({container:"#_list_product"});
                    $('#_modal_edit').modal('toggle');
                } else
                    $('#_form_product_update').replaceWith(getupdatedata);
                //console.log(getupdatedata);
                // $('#_form_product_update form').on('submit', function (e) { e.preventDefault();return false;});
            },
            error  : function () 
            {
                console.log('internal server error');
            },
            });
            return false;
         });
                
        $(document).on('click', "#_list_product td>a[title=Update]", function (e) {
            //request data ajax
            e.preventDefault();
            //$.pjax.reload({url: $(this).attr('href'), container:"#_form_product_update"});
            
            $.ajax({
            type:'GET',
            url: $(this).attr('href'),
            // data:formData,
            //cache:false,
            //contentType: false,
            // processData: false,
            success: function (response) 
            {
                var getupdatedata = $(response).find('#_form_product_update');
                $('#_modal_edit').modal("show");
                $('#_form_product_update').replaceWith(getupdatedata);

                // $('#_form_product_update form').on('submit', function (e) { e.preventDefault();return false;});
            },
            error  : function () 
            {
                console.log('internal server error');
            },
            });
            return false;
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
            'id' => '_popup_create',
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
