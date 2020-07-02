<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class ProductController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Product(), function (Grid $grid) {
            $grid->id->sortable();
//            $grid->image;
            $grid->picture()->image(config('app.url').'/uploads', 100, 100);
            $grid->title;
            //$grid->description;
            $grid->on_sale;
            $grid->rating;
            $grid->sold_count;
            $grid->review_count;
            $grid->price;
            $grid->created_at;
            $grid->updated_at->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Product(), function (Show $show) {
            $show->id;
            $show->title;
            $show->description;
            $show->image;
            $show->on_sale;
            $show->rating;
            $show->sold_count;
            $show->review_count;
            $show->price;
            $show->created_at;
            $show->updated_at;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Product(), function (Form $form) {
            $form->display('id');
            $form->text('title');
            $form->text('description');
            $form->image('image');
//            $form->text('on_sale');
            $form->radio('on_sale', '上架')->options(['1' => '是', '0'=> '否'])->default('0');
            $form->text('rating');
            $form->text('sold_count');
            $form->text('review_count');
            $form->text('price');
            $form->hasMany('skus', 'SKU 列表', function (Form\NestedForm $form) {
                $form->text('title', 'SKU 名称')->rules('required');
                $form->text('description', 'SKU 描述')->rules('required');
                $form->text('price', '单价')->rules('required|numeric|min:0.01');
                $form->text('stock', '剩余库存')->rules('required|integer|min:0');
            });
            // 定义事件回调，当模型即将保存时会触发这个回调
            $form->saving(function (Form $form) {
                $form->model()->price = collect($form->input('skus'))->where(Form::REMOVE_FLAG_NAME, 0)->min('price') ?: 0;
            });
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
