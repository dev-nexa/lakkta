<?php

namespace App\Http\Controllers\Seller;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;
use App\Models\SellerCity;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Hash;
use App\Notifications\ShopVerificationNotification;
use App\Utility\EmailUtility;
use Cache;
use Illuminate\Support\Facades\Notification;

class SellerCityController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:view_all_seller|view_all_seller_rating_and_followers'])->only('index');
        $this->middleware(['permission:add_seller'])->only('create');
        $this->middleware(['permission:view_seller_profile'])->only('profile_modal');
        $this->middleware(['permission:login_as_seller'])->only('login');
        $this->middleware(['permission:pay_to_seller'])->only('payment_modal');
        $this->middleware(['permission:edit_seller'])->only('edit');
        $this->middleware(['permission:delete_seller'])->only('destroy');
        $this->middleware(['permission:ban_seller'])->only('ban');
        $this->middleware(['permission:edit_seller_custom_followers'])->only('editSellerCustomFollowers');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seller_city = SellerCity::all();
        return view('backend.sellers.city.index', compact('seller_city'));
  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $city = new SellerCity;
        $city->name = $request->name;
        $city->save();

        flash(translate('City has been inserted successfully'))->success();
        return redirect()->route('seller.city');
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
    public function edit($id)
    {
        $city = SellerCity::findOrFail($id);
        return view('backend.sellers.city.edit', compact('city'));
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
        $city = SellerCity::findOrFail($id);
        $city->name = $request->name;
        $city->save();

        flash(translate('City has been updated successfully'))->success();
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
        SellerCity::destroy($id);
        flash(translate('City has been deleted successfully'))->success();
        return redirect()->route('seller.city');

    }
}
