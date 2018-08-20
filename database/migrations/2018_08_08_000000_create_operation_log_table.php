<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationLogTable extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up()
	{
		if (!Schema::hasTable('operation_log')) {
			Schema::create('operation_log', function(Blueprint $t) {
		        $t->increments('id');
                $t->unsignedBigInteger('cas_id');
                $t->string('name', 50);
                $t->string('model', 20)->comment('模块');
                $t->unsignedTinyInteger('action');
                $t->text('old_values')->nullable()->comment('旧数据');
                $t->text('new_values')->nullable()->comment('新数据');
                $t->timestamps();
                $t->index(['model', 'action']);
			});
		}
	}

	/**
	 * Revers the migrations
	 */
	public function down()
	{
		Schema::dropIfExists('operation_log');
	}
}