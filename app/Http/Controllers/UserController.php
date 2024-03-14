<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        return view("users.index", compact("users", "roles"));
    }
    public function search1(Request $request)
    {
        $query = User::query();

        if ($request->has('search_query') && $request->search_query != '') {
            $query->where('name', 'like', '%' . $request->search_query . '%')
                ->orWhere('email', 'like', '%' . $request->search_query . '%');
        }

        if ($request->has('status') && $request->status != '' && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Add any additional filters here...

        $users = $query->get();

        return view("users.table_rows", compact("users"));
    }

    public function search(Request $request)
    {
        $columns = ['users.id', 'users.name', 'users.email', 'roles.name as role_name', 'users.created_at']; // Adjust as per your table columns

        $length = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $searchValue = $request->input('search.value');

        // Join with role table to include role information in the query
        $query = User::leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.id', 'users.name', 'users.email', 'roles.name as role_name', 'users.created_at as joining_date');

        // Check if there's a search value
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('users.name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('users.email', 'LIKE', "%{$searchValue}%")
                    ->orWhere('roles.name', 'LIKE', "%{$searchValue}%"); // Search by role name
                // ->orWhere('users.status', 'LIKE', "%{$searchValue}%");
            });
        }

        $recordsTotal = $query->count();

        $data = $query->offset($start)
            ->limit($length)
            ->orderBy($order, $dir)
            ->get();

        // No need to run an additional count query if no additional filters are applied
        $recordsFiltered = $data->count();

        $jsonData = array(
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($recordsTotal),
            'recordsFiltered' => intval($recordsFiltered),
            'data' => $data
        );
        // dd($jsonData);

        return response()->json($jsonData);
    }
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            "name" => ["required", "string", "max:255"],
            "email" => ["required", "string", "email", "max:255", Rule::unique(User::class),],
            "role" => ["required", "string", Rule::exists(Role::class)],
        ])->validate();

        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "role" => Role::find($request->role),
            "password" => Hash::make(Str::random(10)),
        ]);

        return view("users.table_rows", compact("users"))->with("success", "User created Successfully");
    }
}
