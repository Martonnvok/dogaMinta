<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//admin férhet hozzá
Route::middleware( ['admin'])->group(function () {
    Route::apiResource('/api/users', UserController::class);
});

//bejelentkezett felhasználó
Route::middleware('auth.basic')->group(function () {
    Route::apiResource('/copies', CopieController::class);
    //lekérdezések
    //with
    Route::get('/with/book_copy', [BookController::class, 'bookCopy']);
    Route::get('/with/copy_book_lending', [CopieController::class, 'copyBookLending']);
    Route::get('/with/user_l_r', [UserController::class, 'userLR']);
    //moreLendings($copy_id, $db)
    Route::get('more_lendings/{copy_id}/{db}', [CopieController::class, 'moreLendings']);
    Route::get('books_back', [LendingController::class, 'booksBack']);
});

//bejelentkezés nélkül is hozzáférhet
Route::apiResource('/books', BookController::class);
Route::patch('/user_password/{id}', [UserController::class, 'updatePassword']);

