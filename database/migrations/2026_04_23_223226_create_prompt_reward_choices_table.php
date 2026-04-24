<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prompt_reward_choices', function (Blueprint $table) {
            $table->id();
            $table->integer('prompt_id')->unsigned()->default(0);
            $table->integer('reward_choice_group_id')->unsigned();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prompt_reward_choices');
    }
};
