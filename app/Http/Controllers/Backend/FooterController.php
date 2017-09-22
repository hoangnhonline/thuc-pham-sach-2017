<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Blocks;

use Helper, File, Session, Auth;

class FooterController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $items = Blocks::all();
        return view('backend.footer.index', compact( 'items' ));
    }
    public function edit($id)
    {        

        $detail = Blocks::find($id);

        return view('backend.footer.edit', compact('detail'));
    }
    /**
    * Update the specified resource in storage.
    *
    * @param  Request  $request
    * @param  int  $id
    * @return Response
    */
    public function update(Request $request)
    {
        $dataArr = $request->all();
        
        $this->validate($request,[
            'name_vi' => 'required',            
            //'name_en' => 'required'            
        ],
        [
            'name_vi.required' => 'Bạn chưa nhập tên video VI',            
            //'name_en.required' => 'Bạn chưa nhập tên video EN',            
        ]);
       
        $model = Blocks::find($dataArr['id']);
        $model->update($dataArr);      

        Session::flash('message', 'Cập nhật thành công');

        return redirect()->route('footer.index', $dataArr['id']);
    }      
}
