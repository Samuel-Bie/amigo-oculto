<?php

namespace App\Http\Controllers;

use App\Foto;
use App\Presente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoController extends Controller
{
    //

    // GET|HEAD	presentes/{presente}/fotos	fotos.index	App\Http\Controllers\FotoController@
    public function index()
    { }
    // POST	presentes/{presente}/fotos	fotos.store	App\Http\Controllers\FotoController@
    public function store(Presente $presente, Request $request)
    {

        $file = Storage::disk('public')->put('fotos', $request->file('file'));
        $partner = new Foto();
        $partner->path = $file;
        $partner->url = Storage::disk('public')->url($file);
        $partner->presente()->associate($presente);
        $partner->save();
        return response()->json([
            'message' => 'OK'
        ], 201);
    }
    // GET|HEAD	presentes/{presente}/fotos/create	fotos.create	App\Http\Controllers\FotoController@
    public function create()
    { }
    // GET|HEAD	presentes/{presente}/fotos/{foto}	fotos.show	App\Http\Controllers\FotoController@
    public function show()
    { }
    // PUT|PATCH	presentes/{presente}/fotos/{foto}	fotos.update	App\Http\Controllers\FotoController@
    public function update()
    { }
    // DELETE	presentes/{presente}/fotos/{foto}	fotos.destroy	App\Http\Controllers\FotoController@
    public function destroy()
    { }
    // GET|HEAD	presentes/{presente}/fotos/{foto}/edit	fotos.edit	App\Http\Controllers\FotoController@
    public function edit()
    { }
}
