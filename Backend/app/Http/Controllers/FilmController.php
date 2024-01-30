<?php

namespace App\Http\Controllers;

use App\Models\film;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $film = film::latest()->get();
        return response()->json([
            'success'=>true,
            "message"=>"List Data Post",
            "data"=>$film
        ],200);
        //kode 200 adalah jika API berhasil terbaca
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'judul'=>'required',
            'sipnosis'=>'required'
        ]);

        if($validate->fails()){
            return response()->json($validate->errors(), 400);
            //jika validasi gagal maka akan dikembalikan dalam
            //bentuk respon dengan pesan error
        }

        //Insert data ke API
        $film= film::create([
            "judul"=>$request->judul,
            'sipnosis'=>$request->sipnosis
        ]);

        if($film){
            return response()->json([
                "success"=>true,
                "message"=>"Data Berhasil Disimpan",
                "data"=>$film
            ], 201);
        }

        return response()->json([
            'success'=>false,
            "message"=>"Dta gagal disimpan"
        ], 409);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\film  $film
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Mencari data berdasarkan id
        $film=film::findOrfails($id);
        return response()->json([
            'success' => true,
            "message" => "List Data Post",
            "data" => $film
        ], 200);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\film  $film
     * @return \Illuminate\Http\Response
     */
    public function edit(film $film)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\film  $film
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, film $film)
    {
        $validate = Validator::make($request->all(), [
            'judul' => 'required',
            'sipnosis' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $film=film::findOrFail($film->id);

        if ($film) {
            $film->update([
                "judul" => $request->judul,
                'sipnosis' => $request->sipnosis
            ]);
            return response()->json([
                "success" => true,
                "message" => "Data Berhasil Update",
                "data" => $film
            ], 201);
        }

        return response()->json([
            'success' => false,
            "message" => "Dta gagal diupdate"
        ], 409);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\film  $film
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $film = film::findORFail($id);

        if($film){
            $film->destroy();

            return response()->json([
                'success'=>true,
                "message"=>"Data berhasil dihapus"
            ], 200);
        }
        return response()->json([
            'success' => false,
            "message" => "Data gagal dihapus"
        ], 200);
    }
}
