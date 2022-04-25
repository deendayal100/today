<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    public function index(){
        $question = Question::get();
        return view('Pages.admin.questions.index',compact('question'));
    }

    public function upload_csv(Request $request){
        $delimiter =',';
        $header = null;
        $data = array();
        $validator = Validator::make(['question_csv'=>$request->question_csv], [
            'question_csv' => 'required|file'
        ]); 
        if ($validator->fails()) {
            $result=array("status"=>false,"message"=>$validator->errors(),"data"=>1);
        }else{
            if (($handle = fopen($request->question_csv, 'r')) !== false)
            {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
                {
                    if (!$header)
                        $header = $row;
                    else
                        $data[] = array_combine($header, $row);
                }
                fclose($handle);
            }
            for ($i = 0; $i < count($data); $i ++)
            {
               Question::firstOrCreate($data[$i]);
            }
            $result=array("status"=>true,"message"=>"File Uploaded Successfully! ","data"=>0);
        }
        echo json_encode($result);  
    }

}
