<?php

namespace App\Http\Controllers;

use App\Models\Parkir;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class ParkirController extends Controller
{
    //

    public function index(Request $req)
    {
        return view('parkir')
            ->with([
                'user' => Auth::user(),
            ]);
    }

    public function getAll(Request $req)
    {
        try {
            $parkirs = Parkir::all();

            return response()->json([
                'message' => 'success',
                'data' => $parkirs,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Internal Server Error',
                'detail' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getOne(Request $req, $id)
    {
        try {
            $parkir = Parkir::where('id', $id)
                ->first();

            $currDateTime = Carbon::now();
            $createdAt = $parkir->created_at;

            $lamaParkir = $createdAt->diffInHours($currDateTime);

            $biayaParkir = 3000 * $lamaParkir;

            return response()->json([
                'message' => 'success',
                'data' => $parkir,
                'biaya_parkir' => $biayaParkir,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Internal Server Error',
                'detail' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getByDateRange(Request $req, $startDate, $endDate)
    {
        try {
            $parkirs = Parkir::whereBetween('created_date', [$startDate, $endDate])->get();

            return response()->json([
                'message' => 'success',
                'data' => $parkirs,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Internal Server Error',
                'detail' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function keluarParkir(Request $req)
    {
        try {
            $parkir = Parkir::where('id', $req->id)
                ->first();
            $parkir->waktu_keluar = Carbon::now();
            $parkir->biayar_parkir = $req->biaya_parkir;
            $parkir->save();

            return response()->json([
                'message' => 'success',
                'data' => $parkir,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Internal Server Error',
                'detail' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function insert(Request $req)
    {
        try {
            $parkir = new Parkir();
            $parkir->kode_unik = Uuid::uuid4()->toString();
            $parkir->nomor_polisi = $req->nomorPolisi;
            $parkir->save();

            return response()->json([
                'message' => 'success',
                'data' => $parkir,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Internal Server Error',
                'detail' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(Request $req, $id)
    {
        try {
            Parkir::destroy($id);

            return response()->json([
                'message' => 'success',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Internal Server Error',
                'detail' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
