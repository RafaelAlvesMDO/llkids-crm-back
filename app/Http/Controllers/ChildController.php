<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Responsible;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChildController extends Controller
{
    public function registerChild(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'child_name' => 'required|string|max:255',

            'responsibles' => 'required|array|min:1',
            'responsibles.*.name' => 'required|string|max:255',
            'responsibles.*.phone' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $child = Child::create([
            'name' => $request->child_name,
            'created_by_user_id' => auth()->id(),
        ]);

        foreach ($request->responsibles as $responsibleData) {
            $responsible = Responsible::create([
                'name' => $responsibleData['name'],
                'phone' => $responsibleData['phone'],
            ]);

            $child->responsibles()->attach($responsible->id);
        }

        return response()->json([
            'success' => true,
            'message' => 'Criança registrada com sucesso!',
            'child' => [
                'id' => $child->id,
                'name' => $child->name,
            ]
        ], 201);
    }
}
