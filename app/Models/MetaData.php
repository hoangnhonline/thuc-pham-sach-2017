<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MetaData extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'meta_data';	

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
    protected $fillable = [
        'title_vi', 
        'description_vi', 
        'keywords_vi', 
        'custom_text_vi', 
        'title_en', 
        'description_en', 
        'keywords_en', 
        'custom_text_en', 
        'created_user', 
        'updated_user'
    ];
 
}
