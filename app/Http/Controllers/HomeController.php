<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user=User::where('id',Auth::user()->id)->get();
        // dd($user);

        return view('home',["user"=>$user]);
    }


    public function getExamDetails() {

        $user=User::where('id',Auth::user()->id)->get();

        if($user[0]->marks==null){
            $exam_url = 'https://opentdb.com/api.php?amount=10';
            $curl = curl_init ( $exam_url );
            curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
            curl_setopt ( $curl, CURLOPT_POST, false );
            curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, false );
            $curl_response = curl_exec ( $curl );
            curl_close ( $curl );

            if($curl_response!=null){
                $response_code= json_decode($curl_response)->response_code;

                if($response_code==0){

                    $result=json_decode($curl_response)->results;

                    $data=array();
                    $correct_ans = array();
                    $exam_data=array();
                    $quest_ans=array();

                    foreach ($result as $key => $value) {

                        array_push($correct_ans,$value->correct_answer);
                        $exam_data["question"]=$value->question;
                        array_push($value->incorrect_answers,$value->correct_answer);
                        $exam_data["options"]=$value->incorrect_answers;

                        array_push($data, $exam_data);
                        $quest_ans[$key+1] = $value->correct_answer;
                        // array_push($quest_ans, [$key+1 => $value->correct_answer]);

                    }

                    $user_data = User::find(Auth::user()->id);

                    $user_data->correct_ans =serialize($quest_ans);
                    $user_data->save();

                    return view('exam',array("exam_data"=>$data));

                }else{

                    return redirect('home');
                }
            }else{
                return redirect('home');
            }

        }else{
            return redirect('home');
        }
    }

    public function submitExamData(Request $request) {

        $marks=0;
        $json = json_decode(json_encode($request->all()) , true);
        unset($json["_token"]);

        $selected_ans = array();

        $user_data = User::find(Auth::user()->id);

        foreach ($json as $key => $selected_value) {

            $selected_ans[$key]= $selected_value;

        }

        $correct_val=unserialize($user_data->correct_ans);

        // foreach(json_encode($correct_val[0]) as $key => $value)
        // {
        //     echo $key;
        // }
        // echo json_encode($correct_val);
        // die();

       foreach ($selected_ans as $select_key => $select_value) {

        if($select_value==$correct_val[$select_key+1]){
            $marks++;
        }

       }

       $marks=$marks*10;

        $user_data->selected_ans = $selected_ans;
        $user_data->marks = $marks;
        $user_data->save();

        return redirect('home');
    }
}
