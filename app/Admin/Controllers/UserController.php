<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class UserController extends AdminController
{
    protected $title = '用户';

    protected $description = [
        //        'index'  => 'Index',
                'show'   => '展示',
        //        'edit'   => 'Edit',
        //        'create' => 'Create',
    ];
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new User(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->phone->sortable();
            $grid->email;
            $grid->nickname;
            $grid->avatar;
            $grid->wx_openid;
            $grid->ml_openid;
            $grid->created_at->sortable();
            $grid->updated_at->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('phone');

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
        return Show::make($id, new User(), function (Show $show) {
            $show->id;
            $show->phone;
            $show->email;
            $show->nickname;
            $show->avatar;
            $show->wx_openid;
            $show->ml_openid;
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
        return Form::make(new User(), function (Form $form) {
            $form->display('id');
            $form->text('phone');
            $form->text('email');
            $form->text('nickname');
            $form->text('avatar');
            $form->text('wx_openid');
            $form->text('ml_openid');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
