<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function control(Request $request){


        dd($_GET['id']);


        $count = DB::table('messages')->count();

        $query = DB::table('messages')->select([
            'incoming_msg_id',
            DB::raw("count('incoming_msg_id') as m")
        ])->groupBy('incoming_msg_id')->orderBy('m', 'desc')->first();

        $max_incoming_id = $query->incoming_msg_id;
        $repetition_count = $query->m;

        if($repetition_count > 25)
        {
            $del_query = DB::select('select id from messages where incoming_msg_id = :incoming_msg_id', ['incoming_msg_id' => $max_incoming_id]);

            Message::destroy($del_query[0]->id);

            // now delete from json file
        }
    }
}
