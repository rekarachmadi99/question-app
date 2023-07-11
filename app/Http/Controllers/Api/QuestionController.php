<?php

namespace App\Http\Controllers\Api;

//Models
use App\Models\QuestionModel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Resources
use App\Http\Resources\QuestionResource;

//Validator
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    public function index(Request $request){
        if($request->limit === null){
            $question = QuestionModel::all();
        }{
            $question = QuestionModel::paginate($request->limit);
        }

        return new QuestionResource(true,"Daftar Pertanyaan",$question);
    }

    public function show($id){
        $question = QuestionModel::find($id);
        $errors = ["msg" => "Pertanyaan tidak ditemukan!"];
        if($question == null){
            return response()->json($errors,404);
        }
        return new QuestionResource(true,"Daftar Pertanyaan",$question);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'content' => 'required',
            'options' => 'required',
            'correct_option' => 'required','numeric',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $create = QuestionModel::create([
            'title' => $request->title,
            'content' => $request->content,
            'options' => $request->options,
            'correct_option' => $request->correct_option
        ]);

        return new QuestionResource(true,"Pertanyaan berhasil ditambah!", $create);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'content' => 'required',
            'options' => 'required',
            'correct_option' => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $findQuestion = QuestionModel::find($id);
        $errors = ["msg" => "Data tidak ditemukan"];

        if($findQuestion === null){
            return response()->json($errors,400);
        }

        $update = $findQuestion->update([
            'title' => $request->title,
            'content' => $request->content,
            'options' => $request->options,
            'correct_option' => $request->correct_option
        ]);

        return new QuestionResource(true,"Pertanyaan Berhasil diubah!", $update);
    }

    public function destroy($id){
        $question = QuestionModel::destroy($id);

        return new QuestionResource(true,"Berhasil dihapus",$question);
    }

}
