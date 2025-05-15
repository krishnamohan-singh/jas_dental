<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lib\FileManager;
use App\Models\Clinic;
use App\Models\Location;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClinicController extends Controller
{
    public function index(){
        $pageTitle = "All Clinics";
        $emptyMessage = "No Clinics Found";

        $clinics = Clinic::with('location')->latest()->paginate(getPaginate());
        $locations = Location::orderBy('name')->get();

        return view('admin.clinic.index', compact('pageTitle', 'emptyMessage', 'clinics', 'locations'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:13',
            'address' => 'nullable|string',
            'location_id' => 'required|exists:locations,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'map_location' => 'nullable|string',
        ]);

        $clinic = new Clinic();

            if ($request->hasFile('image')) {
            try {
                $clinic->photo = fileUploader($request->image, getFilePath('clinic'), getFileSize('clinic'), $clinic->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $clinic->name = $request->name;
        $clinic->email = $request->email;
        $clinic->phone = $request->phone;
        $clinic->address = $request->address;
        $clinic->location_id = $request->location_id;
        $clinic->map_location = $request->map_location;
        $clinic->save();

        $notify[] = ['success', 'Clinic added successfully'];
    return back()->withNotify($notify);
    }


    public function update(Request $request, $id){
        $clinic = Clinic::findOrFail($id);

        $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'nullable|string|max:13',
        'address' => 'nullable|string',
        'location_id' => 'required|exists:locations,id',
        'image' => 'nullable|image|mimes:jpg,jpeg,png',
        'map_location' => 'nullable|string',
        ]);


    if($request->hasFile('image')){
        try {
            $fileManager = new FileManager($request->file('image'));
            $fileManager->path = getFilePath('clinic');
            $fileManager->size = getFileSize('clinic');
            
            $fileManager->old = $clinic->photo;

            $fileManager->upload();

            $clinic->photo = $fileManager->filename;
            
        } catch (Exception $e) {
            Log::error('error in updating image:', ['error' => $e->getMessage()]);
        }
    }

    Log::info($clinic->photo);

        $clinic->name = $request->name;
        $clinic->email = $request->email;
        $clinic->phone = $request->phone;
        $clinic->address = $request->address;
        $clinic->location_id = $request->location_id;
        $clinic->map_location = $request->map_location;
        $clinic->save();

        $notify[] = ['success', 'Clinic updated successfully'];
        return back()->withNotify($notify);
    }



}
