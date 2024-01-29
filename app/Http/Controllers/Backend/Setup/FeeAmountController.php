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
        $data['allData'] = FeeCategoryAmount::all();
        return view('backend.setup.fee_amount.view_fee_amout', $data);
    }

    public function AddFeeAmount(){
        $data['fee_categories'] = FeelCategory::all();
        $data['classes'] = StudentClass::all();
        return view('backend.setup.fee_amount.add_fee_amout',$data);
    }
}
