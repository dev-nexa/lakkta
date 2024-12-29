<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Model;
use App\Models\BrandTranslation;
use App\Models\Product;
use Illuminate\Support\Str;

class ModelController extends Controller
{
    public function __construct() {
        // Staff Permission Check
        $this->middleware(['permission:view_all_brands'])->only('index');
        $this->middleware(['permission:add_brand'])->only('create');
        $this->middleware(['permission:edit_brand'])->only('edit');
        $this->middleware(['permission:delete_brand'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search =null;
        $models = Model::with('brand')->orderBy('name', 'asc');
        if ($request->has('search')){
            $sort_search = $request->search;
            $models = $models->where('name', 'like', '%'.$sort_search.'%');
        }
        $models = $models->paginate(15);
        $brands = Brand::all();
        return view('backend.product.models.index', compact('models', 'brands', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('brand') && $request->brand != null) {
            $model = new Model;
            $model->name = $request->name;

            
            if ($request->slug != null) {
                $model->slug = str_replace(' ', '-', $request->slug);
            }
            else {
                $model->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5);
            }            
            $model->brand_id = $request->brand; 

            $model->save();
            //$model->brand()->attach($request->brands);

            flash(translate('Model has been inserted successfully'))->success();
            return redirect()->route('models.index');
        }

        flash(translate('Brand is required'))->error();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $model  = Model::findOrFail($id);
        $brands = Brand::all();
        return view('backend.product.models.edit', compact('model', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model = Model::findOrFail($id);

        $model->name = $request->name;

        if ($request->slug != null) {
            $model->slug = strtolower($request->slug);
        }
        else {
            $model->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5);
        }

        $model->brand_id = $request->brand;
        $model->save();

        flash(translate('Model has been updated successfully'))->success();
        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Model::findOrFail($id);
        // TODO ALI
        // Product::where('brand_id', $brand->id)->update(['brand_id' => null]);
        Model::destroy($id);

        flash(translate('Model has been deleted successfully'))->success();
        return redirect()->route('models.index');

    }
}
