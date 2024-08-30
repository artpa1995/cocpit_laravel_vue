<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Questions;
use App\Models\QuestionOptions;

class QuestionsController extends Controller
{
    
    public function add_question(Request $request) {

        return response()->json(['success' =>  true]);
        $last_order = Questions::orderBy('queue', 'desc')->value('queue');

        if(!empty($request->question)){

            $Questions = new Questions();

            $Questions->question = $request->question;
            $Questions->is_required = $request->is_required ? 1 : 0;
            $Questions->type = $request->question_type;
            $Questions->queue =  !empty($last_order) ? $last_order + 1 : 1;            

            if($Questions->save()){

                if(!empty($request->responses)){
                    foreach($request->responses as $responses){
                        $QuestionOptions = new QuestionOptions();
                        $QuestionOptions->question_id =  $Questions->id;
                        $QuestionOptions->option = $responses;
                        $QuestionOptions->save();
                    }
                }

                return response()->json(['success' =>  true]);
            }
            return response()->json(['error' =>  true]);

        }
        
    }

    public function get_questions(){
        return response()->json(['questions' =>   Questions::orderBy('queue', 'ASC')->get(['id', 'question'])]);
    }

    public function get_question($id){

        if(empty($id)){
            return response()->json(['error' =>  true]);
        }

        $Question = Questions::where('id', $id)->with('options')->get()->first()->toArray();

        return response()->json(['question' => $Question]);
    }


    public function add_option(Request $request) {

        if(empty($request->id)){
            return response()->json(['error' =>  true]);
        }
        $QuestionOptions = new QuestionOptions();
        $QuestionOptions->question_id = $request->id;
        $QuestionOptions->save();

        return response()->json(['id' => $QuestionOptions->id]);
    }


    public function edit_option(Request $request) {

        if(empty($request->id)){
            return response()->json(['error' =>  true]);
        }
        $QuestionOptions =  QuestionOptions::where('id', $request->id)->get()->first();

        $QuestionOptions->option = $request->value;
        $QuestionOptions->save();

        return response()->json(['id' => $QuestionOptions->id]);
    }


    public function delete_option(Request $request) {

        if(empty($request->id)){
            return response()->json(['error' =>  true]);
        }
        $QuestionOptions =  QuestionOptions::where('id', $request->id)->get()->first();
        $QuestionOptions->delete();

        return response()->json(['id' => $QuestionOptions->id]);
    }
    

    
}
