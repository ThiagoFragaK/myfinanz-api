<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    protected $table = 'expenses';
	protected $fillable = ['id', 'name', 'description', 'card_id', 'parcel_number', 'value', 'created_at'];
	protected $guarded = ['id'];
	protected $hidden = [];

    public function cards()
	{
		return $this->hasOne('App\Models\Cards', 'id', 'card_id')
            ->select('id', 'name');
	}

    public function user()
	{
		return $this->hasOne('App\Models\User', 'id', 'user_id')
            ->select('id', 'name');
	}
}
