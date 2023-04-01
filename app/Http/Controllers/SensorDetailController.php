<?php

namespace App\Http\Controllers;

use App\Models\Node;
use App\Models\SensorDetail;
use App\Models\SystemStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SensorDetailController extends Controller
{
    public function update_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nodes' => 'required',
            'pump' => 'required',
            'operationMode'=> 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        foreach ($request->nodes as $key => $n) {
            $n = explode(',', $n);
            $node = Node::where('num', '=', $n[0])->get();
            
            if (count($node)>0) {
                $nn = $node[0];
                $sensorDetail = SensorDetail::create([
                    'org_id'=>$nn->org_id,
                    'node_id'=>$nn->id,
                    'temperature'=>$n[1],
                    'humidity'=>$n[2],
                    'moisture'=>$n[3],
                ]);

                $ss = SystemStatus::where('org_id', '=', $nn->org_id)->get();
                if (count($ss)>0) {
                    SystemStatus::where('id','=', $ss[0]->id)->update([
                        "pump"=>$request->pump,
                        "mode"=>$request->operationMode,
                    ]);
                }else{
                    SystemStatus::create([
                        "org_id"=>$nn->org_id,
                        "pump"=>$request->pump,
                        "mode"=>$request->operationMode,
                    ]);
                }
                return response()->json([
                    'status' => true,
                    'message' => "you have updated sensor records",
                ], 422);

            }else{
                return response()->json([
                'status' => false,
                'message' => "node is not found",
            ], 422);
            }
            
        }

        return back()->with('success', "You have updated Node details, Thank you!");
    }
}
