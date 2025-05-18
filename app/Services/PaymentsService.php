<?php

namespace App\Services;

use App\Models\Payments;
use App\Enums\StatusEnum;
use App\Enums\PaymentsEnum;
class PaymentsService
{
    public function getList()
    {
        return Payments::select('id', 'name', 'description', 'value', 'status', 'open', 'due_day')->get();
    }

    public function getPaymentById(int $id)
    {
        return Payments::find($id);
    }

    public function createPayment(String $name, String $description, Float $value, Int $dueDay)
    {
        return Payments::create([
            'name' => $name,
            'description' => $description,
            'value' => $value,
            'due_day' => $dueDay,
            'status' => StatusEnum::Active->value,
            'open' => PaymentsEnum::Open->value,
        ]);
    }

    public function editPayment(Int $id, String $name, String $description, Float $value, Int $dueDay)
    {
        $payment = $this->getPaymentById($id);
        if(is_null($payment))
        {
            return [
                'errors' => "Failed to retrieve Payment",
                'http' => 404
            ];
        }

        return $payment->update([
            "name" => $name,
            "description" => $description,
            "value" => $value,
            "due_day" => $dueDay,
        ]);
    }

    public function disablePayment(Int $id)
    {
        $payment = $this->getPaymentById($id);
        if(is_null($payment))
        {
            return [
                'errors' => "Failed to retrieve Payment",
                'http' => 404
            ];
        }

        return $payment->update([
            "status" => StatusEnum::Inactive->value,
        ]);
    }

    public function payDebt(Int $id)
    {
        $payment = $this->getPaymentById($id);
        if(is_null($payment))
        {
            return [
                'errors' => "Failed to retrieve Payment",
                'http' => 404
            ];
        }

        return $payment->update([
            "open" => PaymentsEnum::Paied->value,
        ]);
    }
}
