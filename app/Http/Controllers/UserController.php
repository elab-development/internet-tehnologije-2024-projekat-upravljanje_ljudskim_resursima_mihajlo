<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function updateRole(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
        return response()->json(['error' => 'User not found'], 400);
        }

        $user->role = $request->role;
        $user->save();

        return response()->json(['message' => 'Uspesno promenjena pozicija', 'user' => $user]);
    }
    

}
