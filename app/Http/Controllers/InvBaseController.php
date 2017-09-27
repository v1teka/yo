<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Requests;
use App\invObject;

class InvBaseController extends Controller
{
    public function ShowFull(){
        $list = invObject::all();
        return view('inventory_list_page')->with('message', $list);
    }

    public function Update(Request $request){
        /*$this->validate($request,
        [
            //'id'=>'required',
            'invNum'=>'required',
            'description'=>'required',
            'room'=>'required',
        ]);*/
        $data = $request->all();
        $computer = new invObject;
        $computer->fill($data);
        $computer->save();
        return 'polucheno servakom';
    }

    public function Register(Request $request){
        $data = $request->all();
        if(/* проверка */true)
            return 'machine had been already registered';
        else{
            return 'machine is registered';
        }
    }

    public function anothersite(){
        $is_loged = false;
        if(!$is_loged)
            return view('auth');
        else
            return view('add_state');
    }

    public function Info(Request $request){
        $fp = fsockopen($request['ip'], 9999);
        fputs($fp, $request['t']);
        $answer = stream_get_contents($fp);
        return $answer;
        fclose($fp);
    }
}
