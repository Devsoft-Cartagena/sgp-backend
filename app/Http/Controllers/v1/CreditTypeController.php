<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\CreditType;
use Illuminate\Http\Request;

class CreditTypeController extends Controller
{
    public function index(Request $request)
    {
        $per_page = isset($request->per_page) ? $request->per_page : 50;

        $types = CreditType::paginate($per_page);

        $types->appends(['per_page' => $per_page]);

        return response()->json(['types' => $types], 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:credit_types',
            'value' => 'integer'
        ]);

        try {
            CreditType::create([
                'name' => $request->name,
                'value' => $request->value
            ]);

            return response()->json([
                'message' => __('messages.credit_type.register')
            ], 201);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 409);
        }
    }

    public function update(Request $request, CreditType $creditType)
    {

        $request->validate([
            'name' => 'required|string|unique:credit_types,name,' . $creditType->id,
            'value' => 'integer'
        ]);

        try {
            $creditType->name = $request->name;
            $creditType->value = $request->value;
            $creditType->save();
            $creditType->refresh();
            return response()->json(['message' => __('messages.credit_type.updated'), 'credit_type' => $creditType], 200);

        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), 409]);
        }
    }

    public function destroy(CreditType $creditType)
    {
        try {
            $creditType->delete();
            return response()->json(['message' => __('messages.credit_type.deleted')], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()]);
        }
    }
}
