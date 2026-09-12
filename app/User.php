<?php

namespace App;

use App\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\Registrasi;

class User extends Authenticatable {
	use LaratrustUserTrait;
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'kelompokkelas_id',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function role() {
		return $this->belongsToMany('App\Role');
	}

	public function registrasi() {
		return $this->hasMany(Registrasi::class);
	}

	public function folio() {
		return $this->hasMany(Folio::class);
	}
}
