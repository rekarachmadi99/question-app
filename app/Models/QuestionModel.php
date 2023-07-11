<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuestionModel extends Model
{
    use HasFactory;

    protected $table = 'question';
    protected $fillable = [
        'title',
        'content',
        'options',
        'correct_option'
    ];

    public function correctQuestion($answer){
        $data = DB::table('question');
        $count = $data->count();
        $point = 0;

        for($i=1;$i<=$count;$i++){
            $soal = 'soal_'.$i;
            $tampungData[$i] = $answer->$soal;
        }
        $i = 1;
        foreach(DB::table('question')->get() as $data){
            if($data->correct_option == $tampungData[$i]){
                $point++;
            }
            $i++;
        }
        $point = ($point/$count)*100;
        return response()->json(["nilai" => $point], 200);
    }

    public function listQuestion($title){
        $data = DB::table('question')->where('title','like', '%'.$title.'%')->get();
        return response()->json($data, 200);
    }

    public function sortQuestion($answer){
        $data = DB::table('question');
        $count = $data->count();
        $point = 0;

        for($i=1;$i<=$count;$i++){
            $soal = 'soal_'.$i;
            $tampungData[$i] = $answer->$soal;
        }
        $i = 1;
        foreach(DB::table('question')->orderBy('id','DESC')->get() as $data){
            if($data->correct_option == $tampungData[$count]){
                $temp[$i] = $data;
            }
            $i++;
            $count--;
        }
        return response()->json($temp, 200);
    }
}
