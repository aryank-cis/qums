<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
	use HasFactory;

	protected	$table = "timelines";
	protected $fillable = [
		'user_id',
		'stage',
		'status'
	];

	protected $hidden = [
		'created_at',
		'updated_at',
	];
}
