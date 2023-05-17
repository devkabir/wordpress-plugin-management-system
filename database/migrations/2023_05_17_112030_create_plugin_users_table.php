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
        Schema::create('plugin_users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20)->nullable();
            $table->string('version',10)->default('1.0.0');
            $table->string('website',100)->nullable();
            $table->text('plugins')->nullable();
            $table->text('server')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->date('activated_at')->default(now());
            $table->date('deactivated_at')->nullable();
            $table->date('uninstalled_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plugin_users');
    }
};
