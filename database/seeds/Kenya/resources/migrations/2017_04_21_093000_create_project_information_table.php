<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_information', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned()->index();
            $table->integer('sponsor_id')->nullable()->unsigned()->index();
            $table->string('ocid')->unique();
            $table->integer('stage_id')->unsigned()->index();

            $table->text('project_need')->nullable();
            $table->boolean('project_need_private')->default(1);

            $table->text('description_asset')->nullable();
            $table->boolean('description_asset_private')->default(1);

            $table->text('rationale_ppp')->nullable();
            $table->boolean('rationale_ppp_private')->default(1);

            $table->text('name_transaction_advisor')->nullable();
            $table->boolean('name_transaction_advisor_private')->default(1);

            $table->text('unsolicited_project')->nullable();
            $table->boolean('unsolicited_project_private')->default(1);

            $table->text('project_summary')->nullable();
            $table->boolean('project_summary_private')->default(1);

            $table->float('project_value_usd',15,5)->nullable();
            $table->float('project_value_second',15,5)->nullable();
            $table->boolean('draft')->default(0);
            $table->boolean('request_modification')->default(0);
            $table->boolean('published')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('project_information');
        Schema::enableForeignKeyConstraints();
    }
}
