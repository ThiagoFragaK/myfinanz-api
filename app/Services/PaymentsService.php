<?php

namespace App\Services;

use App\Models\Payments;
use App\Enums\StatusEnum;
use App\Enums\PaymentsEnum;
class PaymentsService
{
    public function getList()
    {
        return Payments::select('id', 'name', 'description', 'value', 'const_value', 'status', 'open', 'due_day', 'updated_at')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getPaymentById(int $id)
    {
        return Payments::find($id);
    }

    public function createPayment(String $name, String $description, Float $value, Int $constValue, Int $dueDay, String $endDate)
    {
        return Payments::create([
            'name' => $name,
            'description' => $description,
            'value' => $value,
            'due_day' => $dueDay,
            'status' => StatusEnum::Active->value,
            'open' => PaymentsEnum::Open->value,
            'const_value' => $constValue,
            'end_date' => $endDate,
            'user_id' => 1,
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

    public function enablePayment(Int $id)
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
            "status" => StatusEnum::Active->value,
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

    public function openDebt(Int $id)
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
            "open" => PaymentsEnum::Open->value,
        ]);
    }
}
