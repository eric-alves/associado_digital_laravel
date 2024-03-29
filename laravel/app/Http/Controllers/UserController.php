<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct(User $user){
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(["users" => $this->user->with("documentos")->get()], 200);
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
        $this->request = $request;
        $rules = $this->user->rules();

        $rules['cpfcnpj'] = [
            "required",
            Rule::unique('users')->where(function ($query) {
                return $query
                    ->where('cooperativa', $this->request->cooperativa);
            }),
        ];

        $rules['cooperativa'] = [
            "required",
            Rule::unique('users')->where(function ($query) {
                return $query
                    ->where('cpfcnpj', $this->request->cpfcnpj);
            }),
        ];
   
        $request->validate(
            $rules
        );

        $user = $request->all();
        $user["password"] = Hash::make($request->password);
        $user = $this->user->create($user);

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->user->find($id);

        if ($user === null) {
            return response()->json(["error" => "User not found!"], 404);
        } else {
            return response()->json($user, 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $user = $this->user->find($id);

        if ($user === null) {
            return response()->json(["error" => "User not found!"], 404);
        }

        $this->request = $request;
        $this->id = $id;
        $rules = $this->user->rules();

        $rules['email'] = 'required|unique:users,email,'.$this->id;

        $rules['cpfcnpj'] = [
            "required",
            Rule::unique('users')->where(function ($query) {
                return $query
                    ->where('cooperativa', $this->request->cooperativa)
                    ->whereNotIn('id', [$this->id]);
            }),
        ];

        $rules['cooperativa'] = [
            "required",
            Rule::unique('users')->where(function ($query) {
                return $query
                    ->where('cpfcnpj', $this->request->cpfcnpj)
                    ->whereNotIn('id', [$this->id]);
            }),
        ];

        // dd($rules);

        $dynamicRules = array();

        if ($request->method() === 'PATCH') {
            foreach ($rules as $input => $rules) {
                if (array_key_exists($input, $request->all())) {
                    $dynamicRules[$input] = $rules;
                }
            }

            $request->validate($dynamicRules);
        } else {
            $request->validate($rules);
        }

        $user->fill($request->all());
        
        $user->save();

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
