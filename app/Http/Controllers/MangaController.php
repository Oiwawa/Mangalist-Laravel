<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\User;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MangaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Manga::all()->first()->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $user = User::query()->where('id', $user->getAuthIdentifier())->first();
       if ($user){
           $manga = new Manga;
           $manga->titre = $request->input('titre');
           $manga->rating = $request->input('rating');
           $manga->comment = $request->input('comment');
           $manga->user_id = $user->id;

           $manga->save();
       }else{
           abort('403', 'Veuillez vous créer un compte pour ajouter des mangas à votre liste.');
       }
       return $manga->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return string
     */
    public function show(Manga $manga)
    {
        return $manga->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Manga $manga
     * @return string
     */
    public function update(Request $request, Manga $manga)
    {
       if ($request->input('titre') != $manga->titre){
           $manga->titre = $request->input('titre');
       }
       if ($request->input('rating') != $manga->rating){
           $manga->rating = $request->input('rating');
       }
       if ($request->input('comment') != $manga->comment){
           $manga->comment = $request->input('comment');
       }

       $manga->save();
       return $manga->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Manga $manga
     * @return string
     */
    public function destroy(Manga $manga)
    {
        $message = 'Le manga'. $manga->titre .' à été supprimé de votre liste';
        $manga->delete();
        return $message;
    }
}
