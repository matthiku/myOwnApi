<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
* 
*/
class Maker extends Model
{

	protected $table = 'makers';

	protected $fillable = ['name', 'phone'];

	// id shouldn't be hidden as the client needs it to identify records!
	protected $hidden = [ 'created_at', 'updated_at' ];

	public function vehicles() {
		return $this->hasMany('App\Vehicle');
	}

}