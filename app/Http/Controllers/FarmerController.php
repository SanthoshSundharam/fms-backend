<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FarmerController extends Controller
{
    public function index()
    {
        $farmers = Farmer::where('user_id', auth()->id())
            ->with('user:id,name,email')
            ->latest()
            ->get();

        return response()->json([
            'farmers' => $farmers
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'village_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:15',
            'bank_account' => 'required|string|max:20',
            'ifsc_code' => 'required|string|max:11',
            'bank_name' => 'required|string|max:255',
            'branch' => 'required|string|max:255',
            'aadhar_number' => 'nullable|string|size:12',
            'farmer_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $farmerData = $request->except('farmer_image');
        $farmerData['user_id'] = auth()->id();

        if ($request->hasFile('farmer_image')) {
            $path = $request->file('farmer_image')->store('farmers', 'public');
            $farmerData['farmer_image'] = $path;
        }

        $farmer = Farmer::create($farmerData);

        return response()->json([
            'message' => 'Farmer added successfully',
            'farmer' => $farmer
        ], 201);
    }

    public function show($id)
    {
        $farmer = Farmer::where('user_id', auth()->id())->findOrFail($id);

        return response()->json([
            'farmer' => $farmer
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $farmer = Farmer::where('user_id', auth()->id())->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'village_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:15',
            'bank_account' => 'required|string|max:20',
            'ifsc_code' => 'required|string|max:11',
            'bank_name' => 'required|string|max:255',
            'branch' => 'required|string|max:255',
            'aadhar_number' => 'nullable|string|size:12',
            'farmer_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $farmerData = $request->except('farmer_image');

        if ($request->hasFile('farmer_image')) {
            // Delete old image
            if ($farmer->farmer_image) {
                Storage::disk('public')->delete($farmer->farmer_image);
            }
            $path = $request->file('farmer_image')->store('farmers', 'public');
            $farmerData['farmer_image'] = $path;
        }

        $farmer->update($farmerData);

        return response()->json([
            'message' => 'Farmer updated successfully',
            'farmer' => $farmer
        ], 200);
    }

    public function destroy($id)
    {
        $farmer = Farmer::where('user_id', auth()->id())->findOrFail($id);

        if ($farmer->farmer_image) {
            Storage::disk('public')->delete($farmer->farmer_image);
        }

        $farmer->delete();

        return response()->json([
            'message' => 'Farmer deleted successfully'
        ], 200);
    }
}