<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerRequest;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Partner::where('user_id', auth()->user()->id)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PartnerRequest $request)
    {
        $partner = Partner::create($request->validated());

        $partner->customer()->associate(auth()->user());

        $partner->save();

        return response()->json([
            'success' => 'Partner created.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        return $partner;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PartnerRequest $request, Partner $partner)
    {
        $partner->update($request->validated());

        return response()->json([
            'success' => 'Partner updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        $partner->delete();

        return response()->json([
            'success' => 'Partner deleted.'
        ]);
    }
}
