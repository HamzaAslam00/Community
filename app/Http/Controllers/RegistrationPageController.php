<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Models\RegistrationPage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class RegistrationPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registrationPagesCount = RegistrationPage::get()->count();
        return view('registration-pages.index', compact('registrationPagesCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::where('status', 'active')->select('id', 'name')->get();
        return view('registration-pages.modal', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:registration_pages,title',
            'slug' => 'required|unique:registration_pages,slug',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        try{
            DB::beginTransaction();
            $registrationPage = RegistrationPage::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'status' => $request->status,
            ]);
            $registrationPage->groups()->sync($request->default_groups);

            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Registration Page added successfully.',
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
     * @param  \App\Models\RegistrationPage  $registrationPage
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $registrationPage = RegistrationPage::with('groups')->findOrFail($id);
        return view('registration-pages.show', compact('registrationPage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RegistrationPage  $registrationPage
     * @return \Illuminate\Http\Response
     */
    public function edit(RegistrationPage $registrationPage)
    {
        $groups = Group::where('status', 'active')->select('id', 'name')->get();
        $selected_groups = $registrationPage->groups->pluck('id')->toArray();
        return view('registration-pages.modal', compact('registrationPage', 'groups', 'selected_groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RegistrationPage  $registrationPage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RegistrationPage $registrationPage)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:registration_pages,title,'.$registrationPage->id.',id',
            'slug' => 'required|unique:registration_pages,slug,'.$registrationPage->id.',id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        try{
            DB::beginTransaction();
            $registrationPage->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'status' => $request->status,
            ]);
            $registrationPage->groups()->sync($request->default_groups);

            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Registration Page updated successfully.',
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
     * @param  \App\Models\RegistrationPage  $registrationPage
     * @return \Illuminate\Http\Response
     */
    public function destroy(RegistrationPage $registrationPage)
    {
        try 
        {
            $registrationPage->delete();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Registration Page Deleted successfully'
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
        $registrationPages = RegistrationPage::orderBy('id', 'DESC')->get();
        return Datatables::of($registrationPages)
            ->addColumn('actions', function ($record) {
                $actions = '';
                    $actions =  '<div class="drodown">
                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <ul class="link-list-opt no-bdr">
                                    <li>
                                        <a class="dropdown-item" href="'. route('registration-pages.show', $record->id). '" data-toggle="tooltip" data-placement="top" title="View Page">
                                            <em class="icon ni ni-eye"></em><span>View</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-act="ajax-modal" data-method="get" data-action-url="'. route('registration-pages.edit', $record). '" data-title="Edit Page" data-toggle="tooltip" data-placement="top" title="Edit Page">
                                            <em class="icon ni ni-edit"></em><span>Edit</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="delete" href="javascript:void(0)" data-table="registration_pages_table" data-method="get" data-url="' .route('registration-pages.destroy', $record). '" data-toggle="tooltip" data-placement="top" title="Delete Page">
                                            <em class="icon ni ni-trash"></em><span>Delete</span>
                                        </a>
                                    </li>
                                </ul></div></div>';
                return $actions;
            })
            ->addColumn('title', function ($record) {
                return '<a href="javascript:void(0)" class="link" data-act="ajax-modal" data-method="get"
                                data-action-url="'. route('registration-pages.edit', $record). '" data-title="Edit Page"
                                data-toggle="tooltip" data-placement="top" title="Edit Page">'.$record->title.'</a>';
            })
            ->addColumn('slug', function ($record) {
                return $record->slug;
            })
            ->addColumn('status', function ($record) {
                return '<span class="badge badge-'.statusClasses($record->status).'">'. ucfirst($record->status) .'</span>';
            })
            ->rawColumns(['title', 'slug', 'status', 'actions'])
            ->addIndexColumn()->make(true);
    }
}
