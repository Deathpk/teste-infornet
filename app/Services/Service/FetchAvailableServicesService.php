<?php

namespace App\Services\Service;

use App\Models\Service;

class FetchAvailableServicesService
{
    public function handle()
    {
        return Service::paginate(Service::SERVICES_PER_PAGE);
    }
}
