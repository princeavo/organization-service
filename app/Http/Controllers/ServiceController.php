<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Organization;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    public function index($organization_id)
    {
        $services = Service::where("organization_id", $organization_id)->get();
        return response()->json(['success' => true, 'services' => $services, 'message' => " les services de l'organisation"], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'organization_id' => 'required|exists:organizations,id',
            'parent_service_id' => 'nullable|exists:services,id',
        ]);

        $service = Service::create($validatedData);

        return response()->json(['success' => true, 'message' => 'Service created successfully', 'service' => $service], 201);
    }

    public function show($service_id)
    {
        $service = Service::findOrFail($service_id);
        return response()->json(["success" => true, "service" => $service, "message" => "Détails du service"], 200);
    }

    public function update(Request $request, $service_id)
    {
        $service = Service::findOrFail($service_id);

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'parent_service_id' => 'nullable|exists:services,id',
        ]);

        $service->update($validatedData);

        return response()->json(['message' => 'Service updated successfully', 'service' => $service, 'success' => true], 200);
    }

    public function destroy($service_id)
    {
        $service = Service::findOrFail($service_id);
        $service->delete();

        return response()->json(['message' => 'Service deleted successfully', 'success' => true], 200);
    }
}
