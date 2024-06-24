<?php

namespace App\Services\Service;

use App\Models\Service;

class CreateServiceService
{
    public function handle(string $name): void
    {
        Service::create([
            'name' => $name
        ]);
    }
}
