<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Label;
use App\Models\User;
use Egulias\EmailValidator\Result\Reason\LabelTooLong;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Item::class, 'item');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('items.index',[
            'users' => User::all(),
            'labels' => Label::all(),
            'items' => Item::orderBy('obtained','desc')->paginate(6),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('items.create',[
            'labels' => Label::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|max:255',
                'description' => 'required',
                'labels' => 'nullable|array',
                'labels.*' => 'numeric|integer|exists:labels,id',
                'image' => 'file|mimes:jpg,png|max:1024'
            ],
            [
                'required' => 'A mező megadása kötelező',
                'name.required' => 'A név megadása kötelezö',
                'description.required' => 'Leirás megadása kötelezö',

            ]
        );
        $image_path = '';
        if($request->hasFile('image')){
            $file = $request->file('image');
            $image_path = 'image_'.Str::random(16).'.'.$file->getClientOriginalExtension();
            Storage::disk('public')->put($image_path,$file->get());
        }
        else{
            $image_path =null;
        }
        $item = Item::factory()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image' => $image_path,
            'obtained'=>now()
        ]);
        isset($validated['labels']) ?
        $item->labels()->sync($validated['labels']) : "";
        Session::flash('item_created',$validated['name']);
        // Session::flash('name',$validated['name']);
        // Session::flash('style',$validated['style']);
        return redirect()->route('items.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
             return view('items.show',[
                'item' => $item,
                'comments'=>$item->comments->sortByDesc('created_at'),
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $this->authorize('delete',$item);
        $item->delete();
        Session::flash('item_deleted');
        Session::flash('name', $item->name);
        return redirect()->route('items.index');
    }
}
