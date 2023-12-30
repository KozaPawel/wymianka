<?php

use App\Models\Offer;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Offer::class, 'trade_id')
                ->constrained('offers');
            $table->foreignIdFor(User::class, 'by_user_id')
                ->constrained('users');
            $table->integer('rating');
            $table->text('summary')
                ->nullable();
            $table->foreignIdFor(User::class, 'user_id')
                ->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
