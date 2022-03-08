<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionalColumnsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name', 100)->after('name');
            $table->string('middle_name', 100)->after('first_name');
            $table->string('last_name', 100)->after('middle_name');
            $table->string('name_extension', 100)->nullable()->after('last_name');
            $table->integer('role_id')->after('name_extension');
            $table->integer('position_id')->after('role_id');
            $table->text('registered_ip')->after('position_id');
            $table->text('access_token')->after('registered_ip');
            $table->integer('status')->after('registered_ip');
            $table->integer('created_by')->after('created_at');

            $table->index(['role_id, position_id, created_by'], 'user_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('middle_name');
            $table->dropColumn('last_name');
            $table->dropColumn('name_extension');
            $table->dropColumn('role_id');
            $table->dropColumn('position_id');
            $table->dropColumn('registered_ip');
            $table->dropColumn('status');
            $table->dropColumn('created_by');
        });
    }
}
