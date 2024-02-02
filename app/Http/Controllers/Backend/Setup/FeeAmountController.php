<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeeCategoryAmount;
use App\Models\StudentClass;
use App\Models\FeelCategory;

class FeeAmountController extends Controller
{
    public function ViewFeeAmount(){
        // $data['allData'] = FeeCategoryAmount::all();
        $data['allData'] = FeeCategoryAmount::select('fee_category_id')->groupBy('fee_category_id')->get();
        return view('backend.setup.fee_amount.view_fee_amout', $data);
    }
    
    public function AddFeeAmount(){
        $data['fee_categories'] = FeelCategory::all();
        $data['classes'] = StudentClass::all();
        return view('backend.setup.fee_amount.add_fee_amout',$data);
    }

    public function StoreFeeAmount(Request $request){
        $countClass = count($request->class_id);

        if($countClass != NULL){
            for($i=0; $i<$countClass; $i++){
                $fee_amout = new FeeCategoryAmount();
                $fee_amout->fee_category_id = $request->fee_category_id;
                $fee_amout->class_id = $request->class_id[$i];
                $fee_amout->amount = $request->amount[$i];
                $fee_amout->save();
            }
        }

        $notification=array(
            'message'=>'Fee Amount insert  Successfully',
            'alert-type'=>'info',
        );

        return redirect()->route('fee.amount.view')->with($notification);
    }

    public function EditFeeAmount($fee_category_id){
        $data['editData'] = FeeCategoryAmount::where('fee_category_id', $fee_category_id)->orderBy('class_id', 'asc')->get();
        // dd($data['edit']->toArray());
        $data['fee_categories'] = FeelCategory::all();
        $data['classes'] = StudentClass::all();
        return view('backend.setup.fee_amount.edit_fee_amout',$data);
    }

    public function UpdateFeeAmount(Request $request, $fee_category_id){
        if($request->class_id == NULL){
            $notification=array(
                'message'=>'Sorry You do not select any class amount',
                'alert-type'=>'error',
            );
            return redirect()->route('fee.amount.edit', $fee_category_id)->with($notification);

        }else{

            $countClass = count($request->class_id);

            FeeCategoryAmount::where('fee_category_id', $fee_category_id)->delete();
            for($i=0; $i<$countClass; $i++){
                $fee_amout = new FeeCategoryAmount();
                $fee_amout->fee_category_id = $request->fee_category_id;
                $fee_amout->class_id = $request->class_id[$i];
                $fee_amout->amount = $request->amount[$i];
                $fee_amout->save();
            }
            
            $notification=array(
                'message'=>'Fee Amount Update  Successfully',
                'alert-type'=>'success',
            );
            return redirect()->route('fee.amount.view')->with($notification);
        }
    }

    public function DetailsFeeAmount($fee_category_id){
        $data['editData'] = FeeCategoryAmount::where('fee_category_id', $fee_category_id)->orderBy('class_id', 'asc')->get();
        // dd($data['editData']->toArray());
        return view('backend.setup.fee_amount.details_fee_amount',$data);
    }
}
