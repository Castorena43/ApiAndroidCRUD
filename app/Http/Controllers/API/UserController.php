<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function registro(Request $request){
        $user = new \App\User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        if($user->save()){
            return response()->json($user,200);     
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credenciales = ["email"=>$request->email,"password"=>$request->password];
        if(Auth::once($credenciales)){
            $token = Str::random(60);
            $request->user()->forceFill([
                'api_token' => hash('sha256', $token),
            ])->save();
            return response()->json($token,200);
        }
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
    public function update(Request $request)
    {
        $user = new \App\User();
        if($user::where('name', $request->name)
          ->update($request->all())){
            return response()->json("Se actualizo Correctamente",200);
          }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $user = new \App\User();
        if($user::where('name', $request->name)
          ->delete()){
            return response()->json("Se elimino Correctamente",200);
          }
    }
}
