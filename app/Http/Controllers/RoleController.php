<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller
{
    public function view() {
        $data['allData'] = Role::all();

        return response()->json($data, 200);
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {
            $this->validate($request, [
                'name' => 'required|unique:roles,name',
            ]);

            $data = new Role();
            $data->name = $request->name;
            $data->save();

            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
        }

        return response('Data store successfully');
    }

    public function show ($id) {
        $show = Role::find($id);

        return response()->json($show);
    }

    public function update(Request $request, $id) {
        DB::beginTransaction();

        try {
            $data = Role::findOrFail($id);

            $this->validate($request, [
                'name' => 'required|unique:roles,name,'.$data->id
            ]);

            $data->name = $request->name;
            $data->save();

            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
        }

        return response('Data updated successfully');
    }

    public function delete($id) {
        $role = Role::findOrFail($id);
        $role->delete();

        return response('Data deleted successfully');
    }
}
