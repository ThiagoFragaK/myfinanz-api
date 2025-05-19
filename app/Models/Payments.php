<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $table = 'payments';
	protected $fillable = ['id', 'name', 'description', 'value', 'due_day', 'status', 'open', 'user_id', 'created_at'];
	protected $guarded = ['id'];
	protected $hidden = [];

    public function user()
	{
		return $this->hasOne('App\Models\User', 'id', 'user_id')
            ->select('id', 'name');
	}
}
