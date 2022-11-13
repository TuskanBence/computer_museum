<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Label;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\VarDumper\Caster\RedisCaster;

class LabelController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Label::class, 'label');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('items.index', [
            'users' => User::all(),
            'labels' => Label::all(),
            'items' => Item::orderBy('obtained', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('labels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'color' => [
                'required',
                "regex:/^#(?:[0-9a-fA-F]{3}){1,2}$/"
            ],
        ]);
        $validated = $request->validate(
            [
                'color' => 'required',
                'name' => 'required|max:30',
                'display'=>'nullable',
            ],
            [
                'required' => 'A mező megadása kötelező',
                'color.required' => 'A szin megadása kötelezö',
                'name.required' => 'A név megadása kötelezö'
            ]
        );
        $display=false;
        if( $request->has('display') ){
            $display=true;
        }
        Label::factory()->create([
            'name' => $validated['name'],
            'color' => $validated['color'],
            'display'=> $display,
        ]);
        Session::flash('label_created');
        Session::flash('name', $validated['name']);
        Session::flash('color', $validated['color']);
        return redirect()->route('labels.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function show(Label $label)
    {
        return view('labels.show', [
            'label' => $label,
            'items' => Label::where('id', $label->id)->get()[0]->items->sortByDesc('obtained'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function edit(Label $label)
    {
        return view('labels.edit', ['label' => $label]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Label $label)
    {
        $this->validate($request, [
            'color' => [
                'nullable',
                "regex:/^#(?:[0-9a-fA-F]{3}){1,2}$/"
            ],
        ]);
        $validated = $request->validate(
            [
                'color' => 'nullable',
                'name' => 'nullable|max:30',
                'display'=>'nullable',
            ],
            [
                'required' => 'A mező megadása kötelező',
                'color.required' => 'A szin megadása kötelezö',
                'name.required' => 'A név megadása kötelezö'
            ]
        );
        $name = isset($validated['name'])? $validated['name'] : $label->name;
        $color = isset($validated['color'])? $validated['color'] : $label->color;
        $display = isset($validated['display'])? $validated['display'] : $label->display;
       Label::where('id', $label->id)
            ->update(
                [
                    'name' => $name,
                    'color' => $color,
                    'display'=> $display,
                ]
            );
        Session::flash('label_edited');
        Session::flash('name', $validated['name']);
        Session::flash('color', $validated['color']);
        return redirect()->route('labels.show',$label);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        $this->authorize('delete',$label);
        $label->delete();
        Session::flash('label_deleted');
        Session::flash('name', $label->name);
        Session::flash('color', $label->color);
        return redirect()->route('items.index');
    }
}
