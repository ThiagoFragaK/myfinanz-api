<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class IncomeSources extends Model
{
    use HasFactory;

    protected $table = 'income_sources';
	protected $fillable = ['id', 'name', 'status', 'created_at'];
	protected $guarded = ['id'];
	protected $hidden = [];

    public function scopeWhereActive($query)
	{
		return $query->where('status', StatusEnum::Active->value);
	}
}
