<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Category;
use App\QuesAns;
use App\Result;
use App\CategoryDetails;
use App\Http\Controllers\Controller;
use Redirect;
use Session;

class IndustryQuesAnsController extends Controller
{
    public function index($id,Request $request)
    {
        try
        {
            if(!empty($id)){

                //get session data
                $user_id= Session::get('user_id');
                $county_id= \Session::get('user_county');
                $user_subscription= Session::get('user_subscription');

                //get active industry categories
                $categoryData = Category::where('type','0')->where('status', '0')->orderBy('id','ASC')->get();

                //get question-answer for selected category
                $quesData = QuesAns::
                            join('categories','categories.id','category_question_answer.cat_id')
                            ->where('category_question_answer.cat_id',$id)
                            ->where('category_question_answer.status', '0')
                            ->orderBy('category_question_answer.id','ASC')
                            ->get();

                //get selected category details
                $catdata = Category::where('id',$id)->where('status','0')->first();

                //check for fulltest  
                $category = Category::where('type','0')->where('status', '0')->get();
                $totalcategory = Category::where('type','0')->where('status', '0')->get()->count();
               
                $unlockedcategory = CategoryDetails::
                                    join('categories','categories.id','category_details.category_id')
                                    ->where('category_details.user_id', $user_id)
                                    ->where('category_details.is_locked','1')
                                    ->get()->count();

                $count=0;
                foreach ($category as $key => $value) {
                    $category_result=  Result::where('test_result.cat_id',$value->id)
                                    ->where('test_result.user_id',$user_id)
                                    ->orderBy('test_result.id', 'DESC')
                                    ->first();

                    $catDetails= CategoryDetails::where('category_id',$value->id)->where('user_id',$user_id)->orderBy('id','DESC')->first();

                    if(!empty($category_result) && !empty($catDetails)){
                        if($category_result->percentage >= '.80' && $catDetails->is_locked=='1'){
                           $count++;
                        }
                    }
                }

                $catTestDetails= CategoryDetails::
                                    join('categories','categories.id','category_details.category_id')
                                    ->where('category_details.category_id',$id)
                                    ->where('category_details.user_id',$user_id)
                                    ->orderBy('category_details.id','DESC')
                                    ->first();

                $doTest = "";
                if(!empty($catTestDetails) && ($user_subscription == 'free')){
                    $doTest = 'disabled';
                }

                $full_test='Disable';
                if(($totalcategory==$unlockedcategory) && ($unlockedcategory==$count) ){
                    $full_test='Enable';
                }
                //Ends for full test check
                
                if($full_test=='Enable'){
                    $catcount = CategoryDetails::
                            join('categories','categories.id','category_details.category_id')
                            ->where('category_details.user_id',$user_id)
                            ->where('categories.type','0')
                            ->where('category_details.is_locked','1')
                            ->get()
                            ->count();

                }
                else{
                    $catcount = CategoryDetails::
                            join('categories','categories.id','category_details.category_id')
                            ->where('category_details.user_id',$user_id)
                            ->where('categories.type','0')
                            ->where('category_details.is_locked','1')
                            ->where('category_details.category_id','!=',$id)
                            ->get()
                            ->count();

                }
                $count=0;
                foreach ($categoryData as $key => $value) {
                    if($value->id==$id){
                        if($key%2!=0){
                            $color='#1d597d';
                        }
                        else{
                            $color='#F39C13';
                        }
                    }

                    $category_result=  Result::
                                join('category_details','category_details.category_id','test_result.cat_id')
                                ->where('category_details.user_id',$user_id)
                                ->where('test_result.cat_id',$value->id)
                                ->orderBy('test_result.id', 'DESC')
                                ->first();

                    if(!empty($category_result)){
                        if($category_result->percentage >= '.80' && $category_result->is_locked=='1'){
                           $count++;
                         
                        }
                    }
                }
                $full_test_result = '0';
                $full_test_result = Result::where('user_id',$user_id)
                          ->where('test_type','0')
                          ->orderBy('id', 'DESC')
                          ->count();
               
                    $catdetails= CategoryDetails::where('category_id',$id)->where('user_id',$user_id)->first();
                    if(empty($catdetails)){
                        CategoryDetails::create(['is_locked'=>"1",'category_id'=>$id,'user_id'=>$user_id]);
                    }
                    
                $exam_type= Session::get('exam_type_'.$user_id);
                $exam_cat= Session::get('exam_cat_'.$user_id);
                $viewques= 'Enable';
                if(isset($exam_type) || isset($exam_cat)){
                    if($exam_cat==$id){
                        $viewques= 'Disable';
                    } 
                }
                $category_type="0";
                
                return view('user.category.industry_knowledge.category_question_answer',['data' => $quesData, 'cat_id' => $id, 'catdata' => $catdata,'color'=>$color,'viewques'=>$viewques,"category_type"=>$category_type, 'doTest'=>$doTest]);
            }
        }
        catch(\Exception $e)
        {
            // Error Flash msg
            $flashArr = array(
                'msg' => 'Error in category question-answer : '. $e->getMessage(),
                'status' => 'fail'
                );
            $request->session()->flash('err_message', $flashArr);
            return $flashArr;
        }  
    }

   
}
