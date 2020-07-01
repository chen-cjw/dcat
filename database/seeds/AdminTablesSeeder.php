<?php

use Illuminate\Database\Seeder;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // base tables
        Dcat\Admin\Models\Menu::truncate();
        Dcat\Admin\Models\Menu::insert(
            [
                [
                    "id" => 1,
                    "parent_id" => 0,
                    "order" => 1,
                    "title" => "主页",
                    "icon" => "feather icon-bar-chart-2",
                    "uri" => "/",
                    "created_at" => "2020-06-03 07:17:46",
                    "updated_at" => "2020-06-03 07:22:35"
                ],
                [
                    "id" => 2,
                    "parent_id" => 0,
                    "order" => 2,
                    "title" => "Admin",
                    "icon" => "feather icon-settings",
                    "uri" => "",
                    "created_at" => "2020-06-03 07:17:46",
                    "updated_at" => NULL
                ],
                [
                    "id" => 3,
                    "parent_id" => 2,
                    "order" => 3,
                    "title" => "Users",
                    "icon" => "",
                    "uri" => "auth/users",
                    "created_at" => "2020-06-03 07:17:46",
                    "updated_at" => NULL
                ],
                [
                    "id" => 4,
                    "parent_id" => 2,
                    "order" => 4,
                    "title" => "Roles",
                    "icon" => "",
                    "uri" => "auth/roles",
                    "created_at" => "2020-06-03 07:17:46",
                    "updated_at" => NULL
                ],
                [
                    "id" => 5,
                    "parent_id" => 2,
                    "order" => 5,
                    "title" => "Permission",
                    "icon" => "",
                    "uri" => "auth/permissions",
                    "created_at" => "2020-06-03 07:17:46",
                    "updated_at" => NULL
                ],
                [
                    "id" => 6,
                    "parent_id" => 2,
                    "order" => 6,
                    "title" => "菜单",
                    "icon" => NULL,
                    "uri" => "auth/menu",
                    "created_at" => "2020-06-03 07:17:46",
                    "updated_at" => "2020-06-03 15:31:53"
                ],
                [
                    "id" => 7,
                    "parent_id" => 2,
                    "order" => 7,
                    "title" => "Operation log",
                    "icon" => "",
                    "uri" => "auth/logs",
                    "created_at" => "2020-06-03 07:17:46",
                    "updated_at" => NULL
                ],
                [
                    "id" => 8,
                    "parent_id" => 0,
                    "order" => 8,
                    "title" => "会员",
                    "icon" => "fa-address-book",
                    "uri" => "/users",
                    "created_at" => "2020-06-03 15:47:10",
                    "updated_at" => "2020-06-03 15:47:10"
                ]
            ]
        );

        Dcat\Admin\Models\Permission::truncate();
        Dcat\Admin\Models\Permission::insert(
            [
                [
                    "id" => 1,
                    "name" => "Auth management",
                    "slug" => "auth-management",
                    "http_method" => "",
                    "http_path" => "",
                    "order" => 1,
                    "parent_id" => 0,
                    "created_at" => "2020-06-03 07:17:46",
                    "updated_at" => NULL
                ],
                [
                    "id" => 2,
                    "name" => "Users",
                    "slug" => "users",
                    "http_method" => "",
                    "http_path" => "/auth/users*",
                    "order" => 2,
                    "parent_id" => 1,
                    "created_at" => "2020-06-03 07:17:46",
                    "updated_at" => NULL
                ],
                [
                    "id" => 3,
                    "name" => "Roles",
                    "slug" => "roles",
                    "http_method" => "",
                    "http_path" => "/auth/roles*",
                    "order" => 3,
                    "parent_id" => 1,
                    "created_at" => "2020-06-03 07:17:46",
                    "updated_at" => NULL
                ],
                [
                    "id" => 4,
                    "name" => "Permissions",
                    "slug" => "permissions",
                    "http_method" => "",
                    "http_path" => "/auth/permissions*",
                    "order" => 4,
                    "parent_id" => 1,
                    "created_at" => "2020-06-03 07:17:46",
                    "updated_at" => NULL
                ],
                [
                    "id" => 5,
                    "name" => "Menu",
                    "slug" => "menu",
                    "http_method" => "",
                    "http_path" => "/auth/menu*",
                    "order" => 5,
                    "parent_id" => 1,
                    "created_at" => "2020-06-03 07:17:46",
                    "updated_at" => NULL
                ],
                [
                    "id" => 6,
                    "name" => "Operation log",
                    "slug" => "operation-log",
                    "http_method" => "",
                    "http_path" => "/auth/logs*",
                    "order" => 6,
                    "parent_id" => 1,
                    "created_at" => "2020-06-03 07:17:46",
                    "updated_at" => NULL
                ]
            ]
        );

        Dcat\Admin\Models\Role::truncate();
        Dcat\Admin\Models\Role::insert(
            [
                [
                    "id" => 1,
                    "name" => "Administrator",
                    "slug" => "administrator",
                    "created_at" => "2020-06-03 07:17:46",
                    "updated_at" => "2020-06-03 07:17:46"
                ]
            ]
        );

        // pivot tables
        DB::table('admin_role_menu')->truncate();
        DB::table('admin_role_menu')->insert(
            [

            ]
        );

        DB::table('admin_role_permissions')->truncate();
        DB::table('admin_role_permissions')->insert(
            [

            ]
        );

        // finish
    }
}
