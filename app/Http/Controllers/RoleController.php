<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private function Process1() {}
    /**
     * Display a listing of the resource.
     */
    public function index() //GET
    {
        $this->Process1();
        $roles = Role::all();
        return view('roles.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()    //GET
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) //POST
    {
        $validateData = $request->validate([
            'role_name' => 'required|max:255',
            'description' => 'max:255'
        ]);
        $role = Role::create($validateData);
        return redirect()
            ->route('roles.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)    //GET
    {
        $role = Role::find($id);
        return view('roles.show', ['role' => $role]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)    //GET
    {
        $role = Role::find($id);
        return view('roles.edit', ['role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)    //PUT-PATCH
    {
        $role = Role::find($id);
        $validateData = $request->validate([
            'role_name' => 'required|max:255',
            'description' => 'max:255'
        ]);
        $role->update($validateData);
        return redirect()
            ->route('roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) //DELETE
    {
        try {
            $role = Role::find($id);
            $role->delete();
            return redirect()
                ->route('roles.index')
                ->with('success', 'Role was deleted.');
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
