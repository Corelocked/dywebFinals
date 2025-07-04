<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role-list', ['only' => ['index']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $terms = $request->input('q') ?? '';

        $order = $request->input('order') ?? 'desc';
        $limit = $request->input('limit') ?? 20;

        $roles = Role::withCount('users')->orderBy('id', $order);

        if ($terms !== '') {
            $keywords = explode(' ', $terms);

            $roles->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere('name', 'like', '%' . $keyword . '%');
                }
            });
        }

        if ($limit === 0) {
            $roles = $roles->get();
        } else {
            $roles = $roles->paginate($limit);
        }

        return view('role.index', [
            'roles' => $roles,
            'terms' => $terms,
            'order' => $order,
            'limit' => $limit,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $permissions = Permission::get();

        return view('role.create', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array',
        ], [], [
            'name' => 'role name',
            'permissions' => 'permissions'
        ]);

        $role = Role::create(['name' => $request->input('name')]);

        $permissionIds = $request->input('permissions', []);
        $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
        $role->syncPermissions($permissionNames);

        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function show(int $id)
    {
        $role = Role::findOrFail($id);

        $rolePermissions = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('role_has_permissions.role_id', $id)
            ->get();

        return view('role.show', [
            'role' => $role,
            'rolePermissions' => $rolePermissions,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function edit(int $id)
    {
        $role = Role::findOrFail($id);

        if ($role->name == 'Admin') {
            abort(403);
        }

        if ($role->id == Auth::User()->roles[0]->id) {
            abort(403);
        }

        $permissions = Permission::get();
        $rolePermissions = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $id)
            ->pluck('role_has_permissions.permission_id')
            ->all();

        return view('role.edit', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array',
        ], [], [
            'name' => 'role name',
            'permissions' => 'permissions'
        ]);

        $role = Role::findOrFail($id);

        $path = parse_url($request->headers->get('referer'), PHP_URL_PATH);
        $role_id = explode('/', $path)[3];

        if ($role_id != $role->id) {
            abort(403);
        }

        if (! Auth::User()->hasRole('Admin') && $role->id == Auth::User()->roles[0]->id) {
            abort(403);
        }

        $role->name = $request->input('name');
        $role->save();

        $permissionIds = $request->input('permissions', []);
        $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
        $role->syncPermissions($permissionNames);

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        $role = DB::table('roles')->where('id', $id);

        if ($role->get()->isEmpty()) {
            abort(404);
        }

        if ($role->get()[0]->name == 'Admin') {
            abort(403);
        }

        if (Auth::User()->roles[0]->name == $role->get()[0]->name) {
            abort(403);
        }

        $role->delete();

        return redirect()->route('roles.index');
    }
}
