<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Settings;
use File, Session, DB, Auth;

class SettingsController  extends Controller
{
    public function index(Request $request)
    {              
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');

        return view('backend.settings.index', compact( 'settingArr'));
    }

    public function update(Request $request){

    	$dataArr = $request->all();

    	$this->validate($request,[
            'site_name_vi' => 'required',
           // 'site_name_en' => 'required',
            'site_title_vi' => 'required',                  
            'site_description_vi' => 'required',            
            'site_keywords_vi' => 'required',                                    
            //'site_title_en' => 'required',                  
            //'site_description_en' => 'required',            
            //'site_keywords_en' => 'required',                                    
        ],
        [            
            'site_name_vi.required' => 'Bạn chưa nhập tên site VI',            
            'site_title_vi.required' => 'Bạn chưa nhập meta title VI',
            'site_description_vi.required' => 'Bạn chưa nhập meta desciption VI',
            'site_keywords_vi.required' => 'Bạn chưa nhập meta keywords VI.',
           // 'site_name_en.required' => 'Bạn chưa nhập tên site EN',            
            //'site_title_en.required' => 'Bạn chưa nhập meta title EN',
          //  'site_description_en.required' => 'Bạn chưa nhập meta desciption EN',
            //'site_keywords_en.required' => 'Bạn chưa nhập meta keywords EN.'
        ]);  

    	if($dataArr['logo'] && $dataArr['logo_name']){
            
            $tmp = explode('/', $dataArr['logo']);

            if(!is_dir('public/uploads/'.date('Y/m/d'))){
                mkdir('public/uploads/'.date('Y/m/d'), 0777, true);
            }

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('decoos.upload_path').$dataArr['logo'], config('decoos.upload_path').$destionation);
            
            $dataArr['logo'] = $destionation;
        }

        if($dataArr['favicon'] && $dataArr['favicon_name']){
            
            $tmp = explode('/', $dataArr['favicon']);

            if(!is_dir('public/uploads/'.date('Y/m/d'))){
                mkdir('public/uploads/'.date('Y/m/d'), 0777, true);
            }

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('decoos.upload_path').$dataArr['favicon'], config('decoos.upload_path').$destionation);
            
            $dataArr['favicon'] = $destionation;
        }

        if($dataArr['banner'] && $dataArr['banner_name']){
            
            $tmp = explode('/', $dataArr['banner']);

            if(!is_dir('public/uploads/'.date('Y/m/d'))){
                mkdir('public/uploads/'.date('Y/m/d'), 0777, true);
            }

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('decoos.upload_path').$dataArr['banner'], config('decoos.upload_path').$destionation);
            
            $dataArr['banner'] = $destionation;
        }        

        $dataArr['updated_user'] = Auth::user()->id;

        unset($dataArr['_token']);
        unset($dataArr['logo_name']);
        unset($dataArr['favicon_name']);
        unset($dataArr['banner_name']);

    	foreach( $dataArr as $key => $value ){
    		$data['value'] = $value;
    		Settings::where( 'name' , $key)->update($data);
    	}

    	Session::flash('message', 'Cập nhật thành công.');

    	return redirect()->route('settings.index');
    }
}
