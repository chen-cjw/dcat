<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\UserAddress;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class UserAddressController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new UserAddress(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->full_address;
            $grid->contact_name;
            $grid->contact_phone;
            $grid->last_used_at;
//            $grid->user_id;
//            $grid->created_at;
//            $grid->updated_at->sortable();
        
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
        return Show::make($id, new UserAddress(), function (Show $show) {
            $show->id;
            $show->province;
            $show->city;
            $show->district;
            $show->address;
            $show->zip;
            $show->contact_name;
            $show->contact_phone;
            $show->last_used_at;
            $show->user_id;
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
        return Form::make(new UserAddress(), function (Form $form) {
            $form->display('id');
            $form->text('province');
            $form->text('city');
            $form->text('district');
            $form->text('address');
            $form->text('zip');
            $form->text('contact_name');
            $form->text('contact_phone');
            $form->text('last_used_at');
            $form->text('user_id');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
