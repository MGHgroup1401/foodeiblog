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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->string('email')->nullable();
            $table->string('full_name')->nullable();
            $table->text('avatar')->nullable();
            $table->text('comment');
            $table->softDeletes();
            $table->tinyInteger ('status')->default(0)->comment('0 - pendig, 1 - approved, 2 - rejected');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
