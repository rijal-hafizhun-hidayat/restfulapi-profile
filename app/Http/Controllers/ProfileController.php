<?php

namespace App\Http\Controllers;

use App\Models\ProfileModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ProfileModel::orderByDesc('created_at')->get();
        $response = [
            'message' => 'tampilan data profile order by created_at desc',
            'data' => $data,
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required'],
            'gender' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            try {
                $data = ProfileModel::create($request->all());
                $response = [
                    'message' => 'profil created',
                    'data' => $data,
                ];

                return response()->json($response, Response::HTTP_CREATED);
            } catch (QueryException $e) {
                return response()->json([
                    'message' => 'failed, ' . $e->errorInfo
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ProfileModel::findOrFail($id);
        $response = [
            'message' => 'detail resource data',
            'data' => $data,
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = ProfileModel::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nama' => ['required'],
            'gender' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            try {
                $data->update($request->all());
                $response = [
                    'message' => 'profil updated',
                    'data' => $data,
                ];

                return response()->json($response, Response::HTTP_OK);
            } catch (QueryException $e) {
                return response()->json([
                    'message' => 'failed, ' . $e->errorInfo
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ProfileModel::findOrFail($id);

        try {
            $data->delete();
            $response = [
                'message' => 'profil deleted',
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'failed, ' . $e->errorInfo
            ]);
        }
    }

    public function count()
    {
        $data = ProfileModel::select('gender', ProfileModel::raw('count(gender) AS jumlah'))
            ->groupBy('profile.gender')
            ->get();

        $response = [
            'message' => 'tampilan data count',
            'data' => $data
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
