<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Obat;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PengobatansController extends Controller
{
    public function create(Request $request){
        date_default_timezone_set("Asia/Makassar");
        $obat = new Obat;
        $obat->id_user = Auth::user()->id;
        $obat->jenis_penyakit = $request->jenis_penyakit;

        if($request->img !=''){
            $image = time().'jpg';
            file_put_contents('image/'.$image,base64_decode($request->img));
            $obat->img = $image;
        }else{
            $image = 'default.png';
            $obat->img = $image;
        }
        $obat->nama_obat = $request->nama_obat;
        $obat->frekuensi_minum = $request->frekuensi_minum;
        $obat->qty = $request->qty;
        $obat->deskripsi = $request->deskripsi;

        $obat->save();
        $obat->user;

        return response()->json([
            'success'=>true,
            'message'=>'Berhasil Menambahkan Data Reminder',
            'data' => $obat,
        ]);
    }

    public function update(Request $request){
        $obat = Obat::find($request->id);
        if(Auth::user()->id != $obat->id_user){
            return response()->json([
                'success'=>false,
                'message'=>'Unauthorized Access!'
            ]);
        }
        $obat->jenis_penyakit = $request->jenis_penyakit;

        if($request->img !=''){
            $image = time().'jpg';
            file_put_contents('image/'.$image,base64_decode($request->img));
            $obat->img = $image;
        }

        $obat->nama_obat = $request->nama_obat;
        $obat->frekuensi_minum = $request->frekuensi_minum;
        $obat->qty = $request->qty;
        $obat->deskripsi = $request->deskripsi;
        $obat->update();
        $obat->user;
        return response()->json([
            'success'=>true,
            'message'=>'Berhasil Mengedit Data Reminder',
            'data' => $obat,
        ]);
    }

    public function delete(Request $request){
        $obat = Obat::find($request->id);
        $val = Obat::onlyTrashed()->find($request->id);
        if($val!=null){
            return response()->json([
                'success'=>false,
                'message'=>'Data not found!'
            ]);
        }else{
        if(Auth::user()->id != $obat->id_user){
            return response()->json([
                'success'=>false,
                'message'=>'Unauthorized Access!'
            ]);
        }
        
        if($obat->img !='' || $obat->img !='default.png'){
            Storage::delete('image/'.$obat->img);
        }
        $obat->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Berhasil Menghapus Data Reminder',
        ]);
        }
    }

    public function reminder(Request $request){
        $user = User::find(Auth::user()->id);
        $idUser = $user->id;
        $obats = Obat::where(['id_user' => $idUser])->orderBy('id','desc')->get();
        foreach($obats as $obat){
            $obat->user;
        }
        return response()->json([
            'success'=>true,
            'data'=>$obats
        ]);
    }
    
    public function trash(Request $request){
        $user = User::find(Auth::user()->id);
        $idUser = $user->id;
        $obats = Obat::onlyTrashed()->where(['id_user' => $idUser])->orderBy('id','desc')->get();
        foreach($obats as $obat){
            $obat->user;
        }
        return response()->json([
            'success'=>true,
            'data'=>$obats
        ]);
    }
}
