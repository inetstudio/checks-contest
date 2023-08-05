<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Resources\Front\GetWinners;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray($request)
    {
        $userData = $this->resource['additional_info'];

        return [
            'id' => $this->resource['id'],
            'name' => trim(($userData['personal']['surname'] ?? '').' '.($userData['personal']['name'] ?? '').' '.($userData['personal']['middleName'] ?? '')) ?? ($userData['personal']['name'] ?? ''),
            'phone' => $this->hidePhone($userData['personal']['phone']),
            'prizes' => $this['prizes']->map(static function ($prize) {
                return [
                    'id' => $prize->id,
                    'name' => $prize->name,
                ];
            }),
        ];
    }

    protected function hidePhone(string $phone): string
    {
        $phone = str_replace(['+', '-', '(', ')', ' '], '', $phone);
        $lastSymbols = substr($phone, -4);

        return '+7 (***) *** '.substr($lastSymbols, 0, 2).' '.substr($lastSymbols, -2);
    }
}
