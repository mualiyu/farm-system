<?php

namespace App\Http\Controllers;

use App\Models\Actuator;
use App\Models\Node;
use App\Models\SystemStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ActuatorController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actuators = Auth::user()->org->actuators;

        return view("main.actuator.index", compact('actuators'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("main.actuator.crate");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'device_id' => 'nullable',
        ]);

        if ($validator->fails()) {
            return back()->with('error',  $validator->errors()->first());
        }

        $actuator = Actuator::create([
            'org_id'=>Auth::user()->org->id,
            'name'=>$request->name,
            'device_id'=>$request->device_id,
        ]);

        return redirect()->route('actuators')->with('success', "Actuator is created successful.");
    }

    public function store_node(Request $request, Actuator $actuator)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'num' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with('error',  $validator->errors()->first());
        }

        $actuator = Node::create([
            'org_id'=>Auth::user()->org->id,
            'actuator_id'=>$actuator->id,
            'name'=>$request->name,
            'num'=>$request->num,
        ]);

        return back()->with('success', "Node is created successful.");
    }

    public function reset(Request $request, Actuator $actuator)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with('error',  $validator->errors()->first());
        }

        $actuator->update([
            'device_id'=>$request->device_id,
        ]);

        return back()->with('success', "you have changed device ID to " . $request->device_id . ", Thank you!");
    }

    public function update_node(Request $request, Node $node)
    {
        $validator = Validator::make($request->all(), [
            'num' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with('error',  $validator->errors()->first());
        }

        $node->update([
            'name'=>$request->name,
            'num'=>$request->num,
        ]);

        return back()->with('success', "You have update Node, Thank you!");
    }

    public function delete_node(Node $node)
    {
        $node->delete();

        return back()->with('warning', 'Node ('.$node->name.') is deleted.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Actuator  $actuator
     * @return \Illuminate\Http\Response
     */
    public function show(Actuator $actuator)
    {
        $nodes = $actuator->nodes;
        $s_status = SystemStatus::where('org_id','=', Auth::user()->org->id)->get();
        $s_status=$s_status[0];
        return view("main.actuator.info", compact('actuator', 'nodes', 's_status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Actuator  $actuator
     * @return \Illuminate\Http\Response
     */
    public function edit(Actuator $actuator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Actuator  $actuator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Actuator $actuator)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Actuator  $actuator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Actuator $actuator)
    {
        //
    }
}
