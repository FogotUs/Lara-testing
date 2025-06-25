<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class AccountResource extends JsonResource
{
    /**
     * Формирует структуру данных ресурса
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'login'         => $this->login,
            'referral_code' => $this->referral_code,
            'children'      => $this->whenLoaded('childrenWithGrand', function () {
                return $this->childrenWithGrand->map(function ($child) {
                    return [
                        'login'         => $child->login,
                        'referral_code' => $child->referral_code,
                        'children'      => $child->children->map(function ($grand) {
                            return [
                                'login'         => $grand->login,
                                'referral_code' => $grand->referral_code,
                            ];
                        }),
                    ];
                });
            }, []),
        ];
    }
}
