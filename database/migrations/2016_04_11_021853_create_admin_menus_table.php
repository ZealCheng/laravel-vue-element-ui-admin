<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('admin_menus')) {
            Schema::Create('admin_menus', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('pid')->default(0)->comment('菜单关系');
                $table->string('name')->nullable()->comment('菜单名称');
                $table->string('group_name')->nullable()->comment('分组名');
                $table->integer('menu_type')->default(1)->comment('类型 1:导航菜单 2:普通按钮');
                $table->string('language')->default('zh')->comment('语言包');
                $table->tinyInteger('hidden')->default('0')->commnet('是否隐藏');
                $table->string('component')->nullable()->comment('vue组建名称');
                $table->string('icon')->nullable()->comment('图标');
                $table->string('slug')->nullable()->comment('菜单对应的权限');
                $table->string('url')->nullable()->comment('菜单链接地址');
                $table->string('description')->nullable()->comment('描述');
                $table->tinyInteger('sort')->default(0)->comment('排序');
                $table->softDeletes();
                $table->timestamps();
            });
        }   
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_menus');
    }
}
