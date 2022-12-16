<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups_count = Group::get()->count();
        return view('groups.index', compact('groups_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups.modal');
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
            'name' => 'required|unique:groups,name',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        try{
            DB::beginTransaction();
            $path = saveResizeImage($request->group_image, 'group/images', 1024, 'jpg');
            $group = Group::create([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
            ]);
            if($request->has('group_image')){
                $path = saveResizeImage($request->group_image, 'group/images', 1024, 'jpg');
                $group->update([
                    'image' => $path
                ]);
            }
            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Group added successfully.',
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
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        return view('groups.modal', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:groups,name,'.$group->id.',id',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        try{
            DB::beginTransaction();
            $group->update([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
            ]);
            if($request->has('group_image')){
                $path = saveResizeImage($request->group_image, 'group/images', 1024, 'jpg');
                $group->update([
                    'image' => $path
                ]);
            }
            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Group updated successfully.',
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
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        try 
        {
            $group->delete();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Group Deleted successfully'
            ], JsonResponse::HTTP_OK);
        } 
        catch (\Exception $exception) 
        {
            return response()->json([
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR); 
        }
    }
    
    public function dataTable () {
        $groups = Group::orderBy('id', 'DESC')->get();
        return Datatables::of($groups)
            ->addColumn('actions', function ($record) {
                $actions = '';
                    $actions =  '<div class="drodown">
                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <ul class="link-list-opt no-bdr">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-act="ajax-modal" data-method="get" data-action-url="'. route('admin.groups.edit', $record). '" data-title="Edit Group" data-toggle="tooltip" data-placement="top" title="Edit Group">
                                            <em class="icon ni ni-edit"></em><span>Edit</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="delete" href="javascript:void(0)" data-table="groups_table" data-method="get" data-url="' .route('admin.groups.destroy', $record). '" data-toggle="tooltip" data-placement="top" title="Delete Group">
                                            <em class="icon ni ni-trash"></em><span>Delete</span>
                                        </a>
                                    </li>
                                </ul></div></div>';
                return $actions;
            })
            ->addColumn('name', function ($record) {
                
                $image = isset($record->image) ? getImage($record->image) : url("assets/images/no_image.png");
                return '
                    <div class="user-card">
                        <div class="user-avatar">
                            <img src='.$image.' alt="" style="height: inherit;">
                        </div>
                        <div class="user-info">
                            <span class="tb-lead"><a href="javascript:void(0)" class="link" data-act="ajax-modal" data-method="get"
                                data-action-url="'. route('admin.groups.edit', $record). '" data-title="Edit Group"
                                data-toggle="tooltip" data-placement="top" title="Edit Group">'.$record->name.'</a></span>
                            <span>'.$record->email.'</span>
                        </div>
                    </div>';
            })
            ->addColumn('description', function ($record) {
                return addEllipsis($record->description);
            })
            ->addColumn('status', function ($record) {
                return '<span class="badge badge-'.statusClasses($record->status).'">'. ucfirst($record->status) .'</span>';
            })
            ->rawColumns(['name', 'description', 'status', 'actions'])
            ->addIndexColumn()->make(true);
    }
}
