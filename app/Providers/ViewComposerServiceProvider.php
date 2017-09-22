<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\LoaiSp;
use App\Models\Cate;
use App\Models\Blocks;
use App\Models\Settings;

//use App\Models\Entity\SuperStar\Account\Traits\Behavior\SS_Shortcut_Icon;

/**
 * This is provider for using view share
 * @author AnPCD
 */
class ViewComposerServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//Call function composerSidebar
		$this->composerMenu();	
		
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Composer the sidebar
	 */
	private function composerMenu()
	{
		
		view()->composer( '*' , function( $view ){			
	        $settingArr = Settings::whereRaw('1')->lists('value', 'name');	       
	        $loaiSpList = LoaiSp::where('status', 1)->orderBy('display_order')->get();

	       	foreach( $loaiSpList as $loai){
            	$cateList[$loai->id] = Cate::where('loai_id', $loai->id)->orderBy('display_order')->get();         
        	} 
        	$tmp = Blocks::all();
        	foreach($tmp as $tp){
        		$footerArr[$tp->id] = $tp;
        	}
			$view->with(['settingArr' => $settingArr, 'loaiSpList' => $loaiSpList, 'cateList' => $cateList, 'footerArr' => $footerArr]);
		});
	}
	
}
