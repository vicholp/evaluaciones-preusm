<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_groups', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name', 500);
            $table->enum('kind', ['questionnaire', 'question']);
        });

        DB::table('tag_groups')->insert([
            'name' => 'topic',
            'kind' => 'question',
        ]);

        DB::table('tag_groups')->insert([
            'name' => 'subtopic',
            'kind' => 'question',
        ]);

        DB::table('tag_groups')->insert([
            'name' => 'skill',
            'kind' => 'question',
        ]);

        DB::table('tag_groups')->insert([
            'name' => 'item_type',
            'kind' => 'question',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag_groups');
    }
}
