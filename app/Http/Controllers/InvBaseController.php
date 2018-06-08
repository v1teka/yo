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
        if($request['t']==4) fputs($fp, "4".$request['message']);
        else fputs($fp, $request['t']);
        $answer = stream_get_contents($fp);
        fclose($fp);
        return $answer;
    }

    public function Map(Request $request){
    
        return 1;
    }

    public function Draw(Request $request){
        if($request['room']){
            return view('room')->with('number', $request['room']);
        }else{
            return view('rooms');
        }
    }

    public function isOnline(Request $request){
        
    }

    public function arpScan(){
        $arp_scan = shell_exec('arp -a');
        /*$arp_scan = explode("\n", $arp_scan);
        $matches;
        $result = "";
        foreach($arp_scan as $scan) {
            $matches = array();

            if(preg_match('/^([0-9\.]+)[[:space:]]+([0-9a-f:]+)[[:space:]]+(.+)$/', $scan, $matches) != 1) {
                continue;
            }
            
            $ip = $matches[1];/*
	        $mac = $matches[2];
            $desc = $matches[3];
    
            $result .= $ip;
        }*/
        $result = $arp_scan;
        return "<p>$result</p>";  
    }
}
