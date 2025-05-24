<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cards extends Model
{
    use HasFactory;

    protected $table = 'cards';
	protected $fillable = ['id', 'name', 'turn_day', 'limit', 'status', 'user_id', 'created_at', 'updated_at'];
	protected $guarded = ['id'];
	protected $hidden = [];

    public function user()
	{
		return $this->hasOne('App\Models\User', 'id', 'user_id')
            ->select('id', 'name');
	}
}
