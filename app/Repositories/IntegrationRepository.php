<?php

namespace App\Repositories;

use App\Http\Resources\FundingResource;
use App\Models\Funding;
use App\Models\Integrable;
use App\Models\Integration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class IntegrationRepository
{
    public function integrationData($investor)
    {

        $integrations = Integration::whereNotIn('id', function ($query) use ($investor) {
            $query->select('integration_id')
                ->from('integrables')
                ->where('integrable_id', $investor->id)
                ->where('integrable_type', $investor->getMorphClass());
        })->get();

        $integrations_user = $investor->integrations()
            ->orderbypivot('created_at', 'desc')
            ->get();
        $uniqueIntegrations = $integrations_user->unique(function ($integration) {
            return $integration->pivot->integration_id;
        });

        return ['userIntegration' => $uniqueIntegrations, 'integration' => $integrations];

        return $integrations = Integration::all()->map(function($integration) use($investor) {
          return [
            'id' => $integration->id,
            'slug' => $integration->slug,
            'name' => $integration->name,
            'logo' => $integration->logo,
            'external_link' => $integration->external_link,
            'description' => $integration->description,
            'integrated' => $investor->integrations()->where('integrables.id', $integration->id)->exists(),
            // 'connected' => $investor->integrations()->where('integrables.id', $integration->id)
          ];
        });
    }


    public function store($request)
    {

        $imageName = time() . $request->file('logo')->getClientOriginalName();

        $path = 'storage/Integration/' . $imageName;
        $request->file('logo')->storeAs('Integration', $imageName, 'public');

        Integration::create([
            'name' => $request->name,
            'external_link' => $request->external_link,
            'description' => $request->description,
            'logo' => $path
        ]);
    }

    public function logout($integration, $investor)
    {
        $integrable = Integrable::where('integrable_id', $investor->id)->where('integration_id', $integration->id)->orderBy('created_at', 'desc')->first();

        $integrable->update([
            'connected' => !$integrable->connected
        ]);

        return $integrable->connected;
    }
}
