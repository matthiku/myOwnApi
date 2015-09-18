<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
* 
*/
class MyModel extends Model
{

	protected $fillable = ['name', 'phone', 'secrectAttribute', 'password'];
	protected $hidden   = ['secrectAttribute', 'password'];
	
}