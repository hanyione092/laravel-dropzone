<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use http\Env\Response;
use Illuminate\Support\Facades\Hash;
use App\User; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{

	public function index()
	{
		return view('dropzone');
	}

	public function store(Request $request)
	{
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        //400 -> Bad Request/Data
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'photo' => null,
            'password' => Hash::make('password')
        ]);

        return response()->json(['userID'=>$user->id], 200);
	}

	// We are submitting are image along with userid and with the help of user id we are updateing our record
	public function storeImage(Request $request)
	{
		if($request->file('file'))
        {
            try {
                $image = $request->file('file');
                $imageName = strtotime(now()).rand(11111,99999).'.'.$image->getClientOriginalExtension();
    
                $original_name = $image->getClientOriginalName();
    
                $request->file('file')->storeAs('uploads/images', $imageName, 'product_storage');

                // we are updating our image column with the help of user id
                $user = User::where('id', $request->userID)->update([
                    'photo' => $imageName
                ]);
    
                return response()->json(['status'=>"success"], 200);
            } catch (\Throwable $th) {
                return $th;
                return response()->json($th, 409);
            }
        }
        return response()->json(['status'=>"success"], 409);
	}

}
