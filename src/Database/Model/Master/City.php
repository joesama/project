<?php

namespace Joesama\Project\Database\Model\Master;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
	/**
         * The attributes that aren't mass assignable.
         *
         * @var array
         */
        protected $guarded = [];
	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */

	protected $table = 'master_city';

}
