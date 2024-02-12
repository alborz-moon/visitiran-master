<?php

namespace App\Http\Controllers;

use App\Http\Resources\FormResource;
use App\Models\Form;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule as ValidationRule;

class FormController extends Controller
{

    public function getAllStates() {
        
        $states = State::all();
        return response()->json([
            'status' => 'ok',
            'data' => $states
        ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json([
            'status' => 'ok',
            'data' => FormResource::collection(Form::all())->toArray($request)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = [
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'bio' => 'nullable|string|min:1',
            'city_id' => 'required|integer|exists:mysql2.cities,id',
            'phone' => 'required|regex:/(09)[0-9]{9}/',
            'role' => ['required', ValidationRule::in(['student', 'teacher', 'advisor'])]
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);

        $form = Form::create($request->toArray());
        return response()->json([
            'status' => 'ok',
            'id' => $form->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Form $form)
    {
        
        $validator = [
            'first_name' => 'nullable|string|min:2',
            'last_name' => 'nullable|string|min:2',
            'bio' => 'nullable|string|min:1',
            'city_id' => 'nullable|integer|exists:mysql2.cities,id',
            'phone' => 'nullable|regex:/(09)[0-9]{9}/',
            'role' => ['nullable', ValidationRule::in(['student', 'teacher', 'advisor'])]
        ];

        if(self::hasAnyExcept(array_keys($validator), $request->keys()))
            return abort(401);

        $request->validate($validator, self::$COMMON_ERRS);

        foreach($request->keys() as $key)
            $form[$key] = $request[$key];

        $form->save();
        return response()->json([
            'status' => 'ok'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {
        $form->delete();
        return response()->json([
            'status' => 'ok'
        ]);
    }
}
