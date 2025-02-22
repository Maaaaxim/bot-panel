<?php

namespace App\Http\Resources;

use App\Models\BotType;
use App\Models\Manager;
use Illuminate\Http\Resources\Json\JsonResource;

class BotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $botManagers = $this->managers->map(function ($manager) {
            return [
                'id' => $manager->id,
                'name' => $manager->name,
            ];
        });

        $allManagers = Manager::all()->map(function ($manager) {
            return [
                'id' => $manager->id,
                'name' => $manager->name,
            ];
        });

        $allBotTypes = BotType::all()->map(function ($type) {
            return [
                'id' => $type->id,
                'name' => $type->name,
            ];
        });

        $typeInfo = [
            'type_id' => (int)$this->type_id,
            'types' => $allBotTypes,
        ];

        $imageInfo = [
            'image_url' => $this->message_image,
            'image_file' => null,
        ];

        return [
            'id' => $this->id,
            'name' => $this->name,
            'token' => $this->token,
            'message' => $this->message,
            'message_image' => $imageInfo,
            'active' => (int)$this->active,
            'wordpress_endpoint' => $this->wordpress_endpoint,
            'web_hook' => $this->web_hook,
            'type_id' => $typeInfo,
            'managers' => [
                'managers' => $botManagers,
                'allManagers' => $allManagers
            ]
        ];
    }
}
