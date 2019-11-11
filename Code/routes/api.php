<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('importar-clientes-arquivo', 'ImportClientsFromExcel');
Route::post('presale-clientes-arquivo', 'PresaleClientsFromExcel');
Route::post('cancelar-clientes-arquivo', 'CancelClientsFromExcel');
Route::post('subscribe-clientes-arquivo', 'SubscriptionClientsFromExcel');
Route::get('reativacao-claro', 'ReativacaoClaroController');
