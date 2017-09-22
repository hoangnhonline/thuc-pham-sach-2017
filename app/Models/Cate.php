<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Cate extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cate';	

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
        'name_vi',
        'name_en',
        'alias_vi',
        'alias_en',
        'slug_vi',
        'slug_en',
        'description_vi',
        'description_en',
        'is_menu',
        'loai_id',
        'display_order',        
        'status',
        'meta_id',
        'created_user',
        'updated_user'
    ];

    public function sanPham()
    {
        return $this->hasMany('App\Models\Product', 'cate_id');
    }

    public function banners()
    {
        return $this->hasMany('App\Models\Banner', 'object_id')->where('object_type', 2);
    }
}
