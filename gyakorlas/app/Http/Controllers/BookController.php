<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(){
        return Book::all();
    }

    public function show($id){
        return Book::find($id);
    }

    public function destroy($id){
        Book::find($id)->delete();
    }

    public function update(Request $request, $id){
        $book = Book::find($id);
        $book->author = $request->author;
        $book->title = $request->title;
        
        $book->save();
        //még nem létezik...
        //return redirect('/book/list');
    }

    public function store(Request $request){
        $book = new Book();
        $book->author = $request->author;
        $book->title = $request->title;
        
        $book->save();
        //még nem létezik...
        //return redirect('/book/list');
    }

    //with függvények
    public function bookCopy(){
        //a modelben megírt függvényre hivatkozunk..
        return Book::with('copy')->get();
    }

}
