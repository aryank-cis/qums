<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuerySubmission extends Model
{
	use HasFactory, SoftDeletes;

	protected $table = "query_submissions";

	protected $fillable = [
		'name',
		'email',
		'query_type',
		'query_for',
		'query'

	];

	protected $hidden = [
		'created_at',
		'updated_at',
	];


	public function queryUser()
	{
		return $this->belongsTo(User::class, 'query_for', 'id');
	}

	public function QueryDepartment()
	{
		return $this->belongsTo(Departments::class, 'query_type', 'id');
	}
}
