<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        return User::all()->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        $email = $request->input('email');
        $user = User::query()->where('email', $email)->first();
        if (!$user) {
            $user = new User;
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));

            $user->save();
            return $user->toJson();
        }
        abort('403', 'Cet e-mail est déjà associé à un compte sur Mangalist.');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return string
     */
    public function show(User $user)
    {
        return $user->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function createUserToken(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            abort(422, 'Les informations de connnexion fournies sont incorrectes');
        }
        return $user->createToken($user->email)->plainTextToken;
    }
}
