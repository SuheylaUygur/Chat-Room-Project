<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JsonController extends Controller
{
    function index()
    {
        return view('chat');
    }

    function store(Request $request,$outgoing_msg)
    {
        try {
            $incoming_msg = $request->user->id;
            // my data storage location is project_root/storage/app/data.json file.
            $contactInfo = Storage::disk('local')->exists('data.json') ? json_decode(Storage::disk('local')->get('data.json')) : [];

            $inputData = $request->only(['text']);

            date_default_timezone_set('Europe/Istanbul');


            $inputData['datetime_submitted'] = date('Y-m-d H:i:s');
            $inputData['incoming_msg'] = $incoming_msg;
            $inputData['outgoing_mdg'] = $outgoing_msg;

            array_push($contactInfo, $inputData);

            Storage::disk('local')->put('data.json', json_encode($contactInfo));

            $data = DB::table('users')
            ->select('fname')
            ->where('id', '=', $outgoing_msg)
            ->first();

            $data = Validator::make($request->all(), array(
                'text' => 'required|max:100'
            ), [
                'text.required' => 'mesaj kutusu boş !',
                'text.max' => 'tek seferde 100 karakterden fazla mesaj yazamazsınız !',

            ])->validate();

            $msg = $request->input('text');

            DB::table('messages')->insert(
                [
                    'incoming_msg_id' => $incoming_msg,
                    'outgoing_msg_id' => $outgoing_msg,
                    'msg' => $msg
                ]
            );



            $data = DB::table('users')
                ->select('fname')
                ->where('id', '=', $outgoing_msg)
                ->first();
            $flag = true;

            // return message !!!!


            // $all_messages_betweeen_two_user = DB::table('messages')
            // ->select('id')->where([
            //     ['incoming_msg_id', '=', $incoming_msg],
            //     ['outgoing_msg_id', '=', $outgoing_msg]
            // ])->get();

            return view('/chat', [
                'ms' => $inputData['text'],
                'in' => $incoming_msg,
                'out' => $outgoing_msg,
                'id' => $outgoing_msg,
                'fname' => $data->fname,
                'flag' => $flag

            ]);

        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }

    }

    public function data()
    {
        return Storage::disk('local')->exists('data.json') ? Storage::disk('local')->get('data.json') : json_encode([]);
    }
}




