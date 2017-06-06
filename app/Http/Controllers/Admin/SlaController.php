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
        for ($i = 0; $i < count($request->enableLeveL); $i++) {

            if (isset($request->enableLeveL[$i]) && $request->enableLeveL[$i]) {
                $this->validate($request, ['level-' . $i => 'required','days-' . $i => 'required|min:0|integer']);
                $escalate_exist = EscalationLevel::where('sla_id', $sla->id)->where('level', $i + 1)->first();
                if (!$escalate_exist && isset($request->level[$i])) {
                    EscalationLevel::create([
                        'user_id' => User::where('name', $request->level[$i])->first()->id
                        , 'sla_id' => $sla->id, 'level' => '1', 'days' => $request->level_days[$i],
                        'hours' => $request->level_hours[$i], 'minutes' => $request->level_minutes[$i]
                        , 'assign' => $request->has('assign' . ($i + 1)) ? 1 : 0, 'when_escalate' => $request->option . ($i + 1)
                    ]);
                }
            }
        }

//        $sla->update($request->all());
//        $sla->updateCriteria($request);
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
