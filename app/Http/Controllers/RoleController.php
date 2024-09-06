<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('roles', compact('roles', 'permissions'));
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:roles',
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            $role = Role::create(['name' => $request->input('name')]);
            $role->permissions()->sync($request->input('permissions'));

            return redirect()->route('roles.list')->with('success', 'Role created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating role: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error creating the role. Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:roles,name,' . $id,
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            $role = Role::findOrFail($id);
            $role->update(['name' => $request->input('name')]);
            $role->permissions()->sync($request->input('permissions'));

            return redirect()->route('roles.list')->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating role: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error updating the role. Please try again.');
        }
    }

    public function delete($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->permissions()->detach();
            $role->delete();

            return redirect()->route('roles.list')->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting role: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error deleting the role. Please try again.');
        }
    }

    public function getPermissions($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        return response()->json(['permissions' => $role->permissions]);
    }
}