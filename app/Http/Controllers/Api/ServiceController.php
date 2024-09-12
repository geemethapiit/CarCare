<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;


class ServiceController extends Controller
{
    public function index()
    {
        // Fetch all service type names
        $services = Service::all(['ServiceTypeId', 'ServiceTypeName']);

        // Return as JSON
        return response()->json($services);
    }
}
