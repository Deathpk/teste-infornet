<?php

use App\Models\Provider;
use App\Models\ProviderService;
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
        Schema::create('provider_services', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Provider::class)->constrained();
            $table->foreignIdFor(ProviderService::class)->constrained();
            $table->integer('departure_km');
            $table->integer('departure_price');
            $table->integer('over_km_price');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_services');
    }
};