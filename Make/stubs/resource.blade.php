{!! '<' !!}?php

namespace App\Http\Controllers{{$namespace}};

use App\{{ $model}};
@if ($namespace)
use App\Http\Controllers\Controller;
@endif
use Illuminate\Http\Request;

class {{$model}}Controller extends Controller
{

    protected $rules = ['name' => 'required'];

    public function index()
    {
        ${{$plural}} = {{$model}}::paginate();

        return view('{{$viewPrefix}}.index', compact('{{$plural}}'));
    }

    public function create()
    {
        return view('{{$viewPrefix}}.create');
    }

    public function store(Request $request)
    {
        $this->validates($request, 'Could not save {{$humanDown}}');

        {{$model}}::create($request->all());

        flash('{{$humanUp}} has been saved', 'success');

        return \Redirect::route('{{$viewPrefix}}.index');
    }

    public function show({{$model}} ${{$single}})
    {
        return view('{{$viewPrefix}}.show', compact('{{$single}}'));
    }

    public function edit({{$model}} ${{$single}})
    {
        return view('{{$viewPrefix}}.edit', compact('{{$single}}'));
    }

    public function update({{$model}} ${{$single}}, Request $request)
    {
        $this->validates($request, 'Could not save {{$humanDown}}');

        ${{$single}}->update($request->all());

        flash('{{$humanUp}} has been saved', 'success');

        return \Redirect::route('{{$viewPrefix}}.index');
    }

    public function destroy({{$model}} ${{$single}})
    {
        ${{$single}}->delete();

        flash('{{$humanUp}} has been deleted', 'success');

        return \Redirect::route('{{$viewPrefix}}.index');
    }
}
