<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Product extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'product';

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
        'code',
        'name_vi',
        'name_en',
        'alias_vi',
        'alias_en',
        'slug_vi',
        'slug_en',        
        'content_vi',     
        'content_en',
        'thumbnail_id',
        'video_url',
        'loai_id',
        'cate_id',
        'is_hot',
        'is_sale',
        'price',
        'price_sale',
        'price_vnd',
        'views',
        'color_id',
        'display_order',
        'sale_percent',
        'status',
        'meta_id',
        'created_user',
        'updated_user',
        'het_hang'
        ];
    
    public static function getList($is_hot, $is_sale, $cate_id, $loai_id, $limit){
        
        $query = self::where('status', 1)->where('thumbnail_id', '>', 0);
        if($is_hot == 1){
            $query->where('is_hot', 1);
        }
        if($is_sale == 1){
            $query->where('is_sale', 1)->where('price_sale', '>', 0);
        }
        if($cate_id > 0){
            $query->where('cate_id', $cate_id);
        }
        if($loai_id > 0){
            $query->where('loai_id', $loai_id);
        }
        return $query->join('product_img', 'thumbnail_id', '=', 'product_img.id')
            ->select('product.*', 'product_img.image_url')
            ->orderBy('product.id', 'desc')
            ->limit($limit)->get();
    }
}
