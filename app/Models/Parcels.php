<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcels extends Model
{
    use HasFactory;

    protected $table = 'parcels';
	protected $fillable = ['id', 'expense_id', 'card_id', 'value', 'data', 'parcel', 'created_at'];
	protected $guarded = ['id'];
	protected $hidden = [];

    public function cards()
	{
		return $this->hasOne('App\Models\Cards', 'id', 'card_id')
            ->select('id', 'name');
	}

    public function expenses()
	{
		return $this->hasOne('App\Models\Expenses', 'id', 'expenses_id')
            ->select('id', 'name');
	}

    public function user()
	{
		return $this->hasOne('App\Models\User', 'id', 'user_id')
            ->select('id', 'name');
	}
}
