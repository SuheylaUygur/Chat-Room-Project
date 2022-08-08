<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class JsonController extends Controller
{
    function index()
    {
        return view('/chat');
    }

    public function get(Request $request,$outgoing_id)
    {

        $out_id = $outgoing_id;

        $incoming_msg = $request->user->id;

        $all = DB::table('messages')
        ->select(['*'])->where([
            ['incoming_msg_id', '=', $incoming_msg],
            ['outgoing_msg_id', '=', $out_id]
        ])->orWhere([
            ['incoming_msg_id', '=', $out_id],
            ['outgoing_msg_id', '=', $incoming_msg]
        ])->get();

        return response()->json($all);
    }

    function store(Request $request,$outgoing_id)
    {
        try {

            Validator::make($request->all(), array(
                'text' => 'required|max:100'
            ), [
                'text.required' => 'mesaj kutusu boş !',
                'text.max' => 'tek seferde 100 karakterden fazla mesaj yazamazsınız !',

            ])->validate();

            $out_id = $outgoing_id;

            $incoming_msg = $request->user->id;

            $msg = $request->input('text');

           $response = Message::create([
            'incoming_msg_id' => $incoming_msg,
            "outgoing_msg_id" => $out_id,
            "msg" => $msg
        ]);

            return response()->json($response);


        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }

    }
}




