<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsLockedToCharactersTable extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('characters', function (Blueprint $table) {
            $table->boolean('is_locked')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() {
        Schema::table('characters', function (Blueprint $table) {
           $table->dropColumn('is_locked');
        });
    }
}
