<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incomes extends Model
{
    use HasFactory;

    protected $table = 'incomes';
	protected $fillable = ['id', 'name', 'value', 'entry_date', 'source_id', 'type_id', 'user_id', 'status', 'created_at'];
	protected $guarded = ['id'];
	protected $hidden = [];

    public function incomeSources()
	{
		return $this->hasOne('App\Models\IncomeSources', 'id', 'source_id')
            ->select('id', 'name');
	}

    public function types()
	{
		return $this->hasOne('App\Models\IncomeTypes', 'id', 'type_id')
            ->select('id', 'name');
	}

    public function user()
	{
		return $this->hasOne('App\Models\User', 'id', 'user_id')
            ->select('id', 'name');
	}
}
