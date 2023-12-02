<?php

namespace App\Http\Controllers;

use App\Models\Copie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CopieController extends Controller
{
    public function index(){
        return Copie::all();
    }

    public function show($id){
        return Copie::find($id);
    }

    public function destroy($id){
        Copie::find($id)->delete();
    }

    public function update(Request $request, $id){
        $copy = Copie::find($id);
        $copy->book_id = $request->book_id;
        $copy->hardcovered = $request->hardcovered;
        $copy->status = $request->status;
        $copy->publication = $request->publication;
        $copy->save();
    }

    public function store(Request $request){
        $copy = new Copie();
        $copy->book_id = $request->book_id;
        $copy->hardcovered = $request->hardcovered;
        $copy->status = $request->status;
        $copy->publication = $request->publication;
        $copy->save();
        
    }

    public function copyBookLending(){
        //több függvényt is használhatunk
        return Copie::with('book')->with('lending')->get();
    }

    public function moreLendings($copy_id, $db){
        //bejelentkezett felh azon kölcsönzései a példány kódjával, ahol a példányt legalább 2 $db -szer kikölcsönözte 
        $user = Auth::user();
        $lendings = DB::table('lendings as l')
        ->selectRaw('count(*) as number_of_copies, l.copy_id')
        //->join('copies as c', 'l.copy_id','=','c.copy_id')
        ->where('l.user_id', $user->id)
        ->where('l.copy_id', $copy_id)
        ->groupBy('l.copy_id')
        ->having('number_of_copies', '>=', $db)
        ->get();
        return $lendings;
    }
}
