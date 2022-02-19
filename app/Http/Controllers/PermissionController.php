<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class PermissionController extends Controller
{
    public function view() {
        $data['allData'] = Permission::all();

        return response()->json($data, 200);
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {
            $this->validate($request, [
                'name' => 'required|unique:permissions,name'
            ]);

            $data = new Permission();
            $data->name = $request->name;
            $data->save();

            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
        }

        return response('Data store successfully');
    }

    public function show($id) {
        $permission_show = Permission::find($id);

        return response()->json($permission_show, 200);
    }

    public function update(Request $request, $id) {
        DB::beginTransaction();

        try {
            $data = Permission::findOrFail($id);

            $this->validate($request, [
                'name' => 'required|unique:permissions,name,'.$data->id
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
        $permission = Permission::find($id);
        $permission->delete();

        return response('Data deleted successfully');
    }
}
