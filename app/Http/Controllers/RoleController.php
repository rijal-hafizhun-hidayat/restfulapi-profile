<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\RoleModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;

class RoleController extends Controller
{
    public function index()
    {
        $data = RoleModel::orderByDesc('created_at')->get();
        $response = [
            'message' => 'tampilan data profile order by created_at desc',
            'data' => $data
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'username' => 'required',
                'password' => 'required',
                'is_admin' => 'required|numeric'
            ],
            [
                'name.required' => 'form nama wajib di isi',
                'username.required' => 'form username wajib di isi',
                'password.required' => 'form password wajib di isi',
                'is_admin.required' => 'form jenis akun wajib di isi',
                'is_admin.numeric' => 'form jenis akun wajib numeric'
            ]
        );

        // if (!$validator) {
        //     return response()->json($validator, Response::HTTP_CREATED);
        // }

        try {
            $data = RoleModel::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'is_admin' => $request->is_admin
            ]);

            $response = [
                'message' => 'akun created',
                'data' => $data
            ];

            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->errorInfo
            ]);
        }
    }

    public function login(Request $request)
    {
        $val = $request->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'username.required' => 'form username wajib di isi',
                'password.required' => 'form password wajib di isi',
            ]
        );

        if (Auth::attempt($val)) {
            $response = [
                'message' => 'berhasil login',
                'user' => auth()->user(),
                'token' => auth()->guard('api')->attempt($val)
            ];

            return response()->json($response, Response::HTTP_OK);
        }

        return response()->json(['message' => 'username atau password salah'], 401);
    }
}
