<?php

namespace App\Http\Controllers\Admin;

use App\EscalationLevel;
use App\Http\Requests\SlaRequest;
use App\Sla;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Validation\Validator;

class SlaController extends Controller
{
    public function index()
    {
        $slas = Sla::paginate();

        return view('admin.sla.index', compact('slas'));
    }

    public function create()
    {
        return view('admin.sla.create', ['sla' => new Sla()]);
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
        for ($i = 1; $i < count($request->levels); $i++) {

            $escalate_exist = EscalationLevel::where('sla_id', $sla->id)->where('level', $i)->first();

            if (isset($request->levels[$i]['enableLeveL'])) {
                $this->validate($request, ['levels.*.minutes' => 'min:1',]);

                if (!$escalate_exist) {
                    EscalationLevel::create([
                        'user_id' => User::where('name', $request->levels[$i]['technicians'])->first()->id
                        , 'sla_id' => $sla->id, 'level' => $i, 'days' => $request->levels[$i]['days']
                        , 'hours' => $request->levels[$i]['hours'], 'minutes' => $request->levels[$i]['minutes']
                        , 'assign' => $request->levels[$i]['assign'], 'when_escalate' => $request->levels[$i]['when_escalate']
                    ]);
                } else {

                    $escalate_exist->update([
                        'user_id' => User::where('name', $request->levels[$i]['technicians'])->first()->id
                        , 'sla_id' => $sla->id, 'level' => $i, 'days' => $request->levels[$i]['days']
                        , 'hours' => $request->levels[$i]['hours'], 'minutes' => $request->levels[$i]['minutes']
                        , 'assign' => $request->levels[$i]['assign'], 'when_escalate' => $request->levels[$i]['when_escalate']
                    ]);

                }


            } elseif ($escalate_exist && !isset($request->levels[$i]['enableLeveL'])) {
                $escalate_exist->delete();
            }
        }

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
