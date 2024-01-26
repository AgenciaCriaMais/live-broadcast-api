<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password'))
            ]);
            return response(['usuario' => $user], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $users = User::findOrFail($id);
            return response()->json($users);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User não encontrado'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $users = User::findOrFail($id);
            $users->update($request->all());
            return response()->json($users);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User não encontrado'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);
        return response()->json(['message' => 'User foi Excluído com sucesso'], 204);
    }
}
