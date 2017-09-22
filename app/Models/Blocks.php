<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Blocks extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'blocks';

	 /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name_vi', 'name_en', 'content_vi', 'content_en'];
}