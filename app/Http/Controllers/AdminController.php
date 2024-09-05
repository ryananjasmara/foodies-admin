<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        return view('admins', compact('admins'));
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string|max:255|unique:admins',
                'password' => 'required|string',
                'name' => 'required|string|max:255',
                'role' => 'required|string|max:255',
            ]);

            Admin::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'name' => $request->name,
                'role' => $request->role,
            ]);

            return redirect()->route('admins.list')->with('success', 'Admin created successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating admin: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error creating the admin. Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $admin = Admin::findOrFail($id);

            $request->validate([
                'username' => 'required|string|max:255|unique:admins,username,' . $admin->id,
                'name' => 'required|string|max:255',
                'role' => 'required|string|max:255',
                'password' => 'nullable|string',
            ]);

            $admin->username = $request->username;
            $admin->name = $request->name;
            $admin->role = $request->role;
            if ($request->password) {
                $admin->password = Hash::make($request->password);
            }
            $admin->save();

            return redirect()->route('admins.list')->with('success', 'Admin updated successfully.');
        } catch (ModelNotFoundException $e) {
            Log::error('Admin not found: ' . $e->getMessage());
            return redirect()->route('admins.list')->with('error', 'Admin not found.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating admin: ' . $e->getMessage());
            return redirect()->route('admins.list')->with('error', 'There was an error updating the admin. Please try again.');
        }
    }

    public function delete($id)
    {
        try {
            $admin = Admin::findOrFail($id);
            $admin->delete();

            return redirect()->route('admins.list')->with('success', 'Admin deleted successfully.');
        } catch (ModelNotFoundException $e) {
            Log::error('Admin not found: ' . $e->getMessage());
            return redirect()->route('admins.list')->with('error', 'Admin not found.');
        } catch (\Exception $e) {
            Log::error('Error deleting admin: ' . $e->getMessage());
            return redirect()->route('admins.list')->with('error', 'There was an error deleting the admin. Please try again.');
        }
    }
}