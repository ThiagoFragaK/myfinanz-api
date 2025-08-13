<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    protected $table = 'expenses';
	protected $fillable = ['id', 'name', 'description', 'payment_methods_id', 'user_id', 'parcel_number', 'value', 'date', 'created_at'];
	protected $guarded = ['id'];
	protected $hidden = [];

    public function paymentMethods()
	{
		return $this->hasOne('App\Models\PaymentMethods', 'id', 'payment_methods_id')
            ->select('id', 'name');
	}

    public function user()
	{
		return $this->hasOne('App\Models\User', 'id', 'user_id')
            ->select('id', 'name');
	}
}
