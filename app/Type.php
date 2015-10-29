<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    //

    protected $fillable = ['name'];
    
	protected $hidden = [ 'id', 'created_at', 'updated_at' ];


	public function vehicles() {
		return $this->hasMany('App\Vehicle');
	}


}


