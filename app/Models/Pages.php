<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Pages extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pages';

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
        'title_en',
        'alias_vi',
        'alias_en',
        'slug_vi',
        'slug_en',
        'description_vi',
        'description_en',
        'content_vi',
        'content_en',                
        'status',
        'meta_id',
        'created_user',
        'updated_user'
        ];
    
}
