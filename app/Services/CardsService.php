<?php

namespace App\Services;
use App\Models\Cards;
use App\Enums\StatusEnum;
class CardsService
{
    public function getList()
    {
        return Cards::select('id', 'name', 'limit', 'turn_day', 'status')->get();
    }

    public function getCardById(int $id)
    {
        return Cards::find($id);
    }

    public function createCard(String $name, Int $turnDay, Float $limit)
    {
        return Cards::create([
            'name' => $name,
            'turn_day' => $turnDay,
            'limit' => $limit,
            'status' => StatusEnum::Active->value,
            'user_id' => 1,
        ]);
    }

    public function editCard(Int $id, String $name, Int $turnDay, Float $limit)
    {
        $card = $this->getCardById($id);
        if(is_null($card))
        {
            return [
                'errors' => "Failed to retrieve Card",
                'http' => 404
            ];
        }

        return $card->update([
            'name' => $name,
            'turn_day' => $turnDay,
            'limit' => $limit,
        ]);
    }

    public function disableCard(Int $id)
    {
        $card = $this->getCardById($id);
        if(is_null($card))
        {
            return [
                'errors' => "Failed to retrieve Card",
                'http' => 404
            ];
        }

        return $card->update([
            'status' => StatusEnum::Inactive->value
        ]);
    }

    public function enableCard(Int $id)
    {
        $card = $this->getCardById($id);
        if(is_null($card))
        {
            return [
                'errors' => "Failed to retrieve Card",
                'http' => 404
            ];
        }

        return $card->update([
            'status' => StatusEnum::Active->value
        ]);
    }
}
