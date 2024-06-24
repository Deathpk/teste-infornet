<?php

namespace App\Services\Service;

use App\Models\Service;

class UpdateServiceService
{
    public function handle(Service $service, string $name): void
    {
        $service->update([
            'name' => $name
        ]);

        $service->save();
    }
}
