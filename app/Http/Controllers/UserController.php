<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userCount = User::get()->count();
        return view('users.index', compact('userCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.modal');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|regex:/^[A-Za-z ]+$/',
            'last_name' => 'required|regex:/^[A-Za-z ]+$/',
            'email' => 'required|email|unique:users',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        try{
            DB::beginTransaction();
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make(12345678),
                'user_type' => 'user',
                'status' => $request->status,
            ]);
            if($request->has('avatar')){
                $path = saveResizeImage($request->avatar, 'user/avatar', 1024, 'jpg');
                $user->update([
                    'avatar' => $path
                ]);
            }
            $user->assignRole('user');

            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'User created successfully.',
            ], JsonResponse::HTTP_OK);

        } catch(Exception $e){
            DB::rollback();
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($id == 1) {
            abort(401);
        }
        $user = User::findOrFail($id);
        return view('users.modal', compact('user'));
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
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|regex:/^[A-Za-z ]+$/',
            'last_name' => 'required|regex:/^[A-Za-z ]+$/',
            'email' => 'required|email|unique:users,email,'.$id.'id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        try{
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'status' => $request->status,
            ]);
            if($request->has('avatar')){
                $path = saveResizeImage($request->avatar, 'user/avatar', 1024, 'jpg');
                $user->update([
                    'avatar' => $path
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'User updated successfully.',
            ], JsonResponse::HTTP_OK);

        } catch(Exception $e){
            DB::rollback();
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try 
        {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'User Deleted successfully'
            ], JsonResponse::HTTP_OK);
        } 
        catch (\Exception $exception) 
        {
            return response()->json([
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR); 
        }
    }

    public function dataTable ()
    {
        $users = User::where('id', '!=', '1')->get();
        return Datatables::of($users)
            ->addColumn('actions', function ($record) {
                $actions = '';
                    $actions =  '<div class="drodown">
                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <ul class="link-list-opt no-bdr">
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)" data-act="ajax-modal" data-method="get" data-action-url="'. route('admin.users.edit', $record->id). '" data-title="Edit User" data-toggle="tooltip" data-placement="top" title="Edit User">
                                                    <em class="icon ni ni-edit"></em><span>Edit</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="delete" href="javascript:void(0)" data-table="users_table" data-method="get" data-url="' .route('admin.users.destroy', $record->id). '" data-toggle="tooltip" data-placement="top" title="Delete User">
                                                    <em class="icon ni ni-trash"></em><span>Delete</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>';
                return $actions;
            })
            ->addColumn('name', function ($record) { 
                // <span class="dot dot-warning d-md-none ml-1"></span>
                $avatar = isset($record->avatar) ? getImage($record->avatar) : url("assets/images/no_avatar.png");
                return '
                    <div class="user-card">
                        <div class="user-avatar">
                            <img src='.$avatar.' alt="" style="height: inherit;">
                        </div>
                        <div class="user-info">
                            <span class="tb-lead"><a href="javascript:void(0)" class="link" data-act="ajax-modal" data-method="get"
                                data-action-url="'. route('admin.users.edit', $record->id). '" data-title="Edit User"
                                data-toggle="tooltip" data-placement="top" title="Edit User">'.getFullName($record).'</a></span>
                            <span>'.$record->email.'</span>
                        </div>
                    </div>';
            })
            ->addColumn('status', function ($record) {
                return '<span class="badge badge-'.statusClasses($record->status).'">'. ucfirst($record->status) .'</span>';
            })
            ->rawColumns(['name', 'status', 'actions'])
            ->addIndexColumn()->make(true);
    }
}
