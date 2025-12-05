<?php

namespace App\Services;
use App\Models\PaymentMethods;
use App\Enums\StatusEnum;
class PaymentMethodsService
{
    public function getList(Int $userId)
    {
        return PaymentMethods::select('id', 'name', 'type', 'limit', 'turn_day', 'status')
            ->where('user_id', $userId)
            ->paginate(10);
    }

    public function getMethodsList(Int $userId)
    {
        return PaymentMethods::where('user_id', $userId)->select('id', 'name')->get();
    }

    public function getPaymentMethodById(int $id)
    {
        return PaymentMethods::find($id);
    }

    public function createPaymentMethod(Int $userId, String $name, Int $type, Int $turnDay, Float $limit)
    {
        return PaymentMethods::create([
            'name' => $name,
            'turn_day' => $turnDay,
            'limit' => $limit,
            'type' => $type,
            'status' => StatusEnum::Active->value,
            'user_id' => $userId,
        ]);
    }

    public function editPaymentMethod(Int $id, String $name, Int $type, Int $turnDay, Float $limit)
    {
        $card = $this->getPaymentMethodById($id);
        if(is_null($card))
        {
            return [
                'errors' => "Failed to retrieve Card",
                'http' => 404
            ];
        }

        return $card->update([
            'name' => $name,
            'type' => $type,
            'turn_day' => $turnDay,
            'limit' => $limit,
        ]);
    }

    public function disablePaymentMethod(Int $id)
    {
        $card = $this->getPaymentMethodById($id);
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
        $card = $this->getPaymentMethodById($id);
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
