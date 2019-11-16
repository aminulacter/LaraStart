<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return User::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|unique:users|max:255',
            'type' => 'required',
            'bio'  => 'required',
            'password' =>'required|min:8'
        ]);

        
        return User::create([
            'name' => request()->name,
            'email'=> request()->email,
            'type'=> request()->type,
            'bio'=> request()->bio,
            'password'=> Hash::make(request()->password)
            ]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|unique:users|max:255',
            'type' => 'required',
            'bio'  => 'required',
            'password' =>'required|min:8'
        ]);
        $user->name = request()->name;
        $user->email= request()->email;
        $user->type= request()->type;
        $user->bio= request()->bio;
        $user->password= Hash::make(request()->password);
        $user->save();
        return response()->json(['user' => $user]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $name = $user->name;
        $user->delete();
       return response()->json(['message' => $name . "is Deleted"]);
    //    return response()->json([
    //     'name' => 'Abigail',
    //     'state' => 'CA'
    // ]);
  }
}
