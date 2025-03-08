<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationController extends Controller
{
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'domains' => 'nullable|array',
            'standards' => 'nullable|array',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'step' => 'nullable|string',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('organization-logo', 'public');
            $validatedData['logo'] = $logoPath;
        }

        $validatedData['domains'] = json_encode(Arr::get($validatedData,"domains",[]));
        $validatedData['standards'] = json_encode(Arr::get($validatedData,"standards",[]));
        $validatedData['owner_id'] = $request['user']['id'];

        $organization = Organization::create($validatedData);

        $organization->logo = config("app.APP_GATEWAY_URL") . "/organization/storage/" .  $organization->logo;

        return response()->json(['success' => true,'message' => 'Organization created successfully', 'organization' => $organization], 201);
    }
}
