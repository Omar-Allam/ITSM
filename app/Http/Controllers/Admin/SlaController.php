<?php

namespace App\Http\Controllers\Admin;

use App\EscalationLevel;
use App\Http\Requests\SlaRequest;
use App\Sla;
use App\Http\Controllers\Controller;
use App\User;

class SlaController extends Controller
{
    public function index()
    {
        $slas = Sla::paginate();

        return view('admin.sla.index', compact('slas'));
    }

    public function create()
    {
        return view('admin.sla.create');
    }

    public function store(SlaRequest $request)
    {

        $sla = Sla::create($request->all());
        $sla->updateCriteria($request);

        flash('SLA has been saved', 'success');

        return \Redirect::route('admin.sla.index');
    }

    public function show(Sla $sla)
    {
        return view('admin.sla.show', compact('sla'));
    }

    public function edit(Sla $sla)
    {
        $sla->load('criterions');

        return view('admin.sla.edit', compact('sla'));
    }

    public function update(Sla $sla, SlaRequest $request)
    {

//
//        if (isset($request->enableLeveL[0])) {
//            EscalationLevel::firstOrCreate([
//                'email' => User::where('name', $request->level[0])->first()->email
//                , 'sla_id' => $sla->id, 'level' => '1','days'=>$request->level_days[0],
//                'hours'=>$request->level_hours[0],'minutes'=>$request->level_minutes[0]
//            ]);
//        }



//        //get technician ids .
//        if ($request->has('tech') && collect($request->get('tech'))->count()) {
//            foreach ($request->tech as $tech) {
//                $technician  = User::find($tech);
//                EscalationLevel::create(['name'=>$technician->name,'email'=>$technician->email,'sla_id'=>$sla->id]);
//            }
//        }
        $sla->update($request->all());
        $sla->updateCriteria($request);

        flash('SLA has been saved', 'success');

        return \Redirect::route('admin.sla.index');
    }

    public function destroy(Sla $sla)
    {
        $sla->delete();

        flash('SLA has been deleted', 'success');

        return \Redirect::route('admin.sla.index');
    }
}
