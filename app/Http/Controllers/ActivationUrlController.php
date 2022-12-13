<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\ActivationUrl;
use App\Models\RegistrationPage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ActivationUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activationUrlsCount = ActivationUrl::get()->count();
        return view('activation-urls.index', compact('activationUrlsCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $registrationPages = RegistrationPage::where('status', 'active')->select('id', 'title')->get();
        $tickets = Ticket::where('status', 'active')->get();
        $users = User::role('user')->get();
        // $groups = Group::where('status', 'active')->select('id', 'name')->get();
        return view('activation-urls.create', compact('registrationPages', 'tickets', 'users'));
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
            'registration_page_id' => 'required',
        ],[
            'registration_page_id.required' => 'Please select registration page.'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        try{
            DB::beginTransaction();
            $slug = RegistrationPage::findOrFail($request->registration_page_id)->slug;
            $activationUrl = ActivationUrl::create([
                'registration_page_id' => $request->registration_page_id,
                'user_id' => $request->user_id,
                'url' => route('register', $slug),
            ]);
            $activationUrl->tickets()->sync($request->tickets);
            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Activation Url generated successfully.',
                'redirect' => route('activation-urls.edit', $activationUrl),
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
     * @param  \App\Models\ActivationUrl  $activationUrl
     * @return \Illuminate\Http\Response
     */
    public function show(ActivationUrl $activationUrl)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ActivationUrl  $activationUrl
     * @return \Illuminate\Http\Response
     */
    public function edit(ActivationUrl $activationUrl)
    {
        $registrationPages = RegistrationPage::where('status', 'active')->select('id', 'title')->get();
        $tickets = Ticket::where('status', 'active')->get();
        $users = User::role('user')->get();
        // $groups = Group::select('id', 'name')->get();
        return view('activation-urls.create', compact('registrationPages' , 'tickets', 'activationUrl', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActivationUrl  $activationUrl
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ActivationUrl $activationUrl)
    {
        $validator = Validator::make($request->all(), [
            'registration_page_id' => 'required',
        ],[
            'registration_page_id.required' => 'Please select registration page.'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        try{
            DB::beginTransaction();
            $slug = RegistrationPage::findOrFail($request->registration_page_id)->slug;
            $activationUrl->update([
                'registration_page_id' => $request->registration_page_id,
                'user_id' => $request->user_id,
                'url' => route('register', $slug),
                'status' => $request->status,
            ]);
            $activationUrl->tickets()->sync($request->tickets);
            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Activation Url updated successfully.',
                'redirect' => route('activation-urls.edit', $activationUrl),
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
     * @param  \App\Models\ActivationUrl  $activationUrl
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActivationUrl $activationUrl)
    {
        try 
        {
            $activationUrl->delete();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Activation Url Deleted successfully'
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
        $activationUrls = ActivationUrl::with('registrationPage', 'tickets')->orderBy('id', 'DESC')->get();
        return Datatables::of($activationUrls)
            ->addColumn('actions', function ($record) {
                $actions = '';
                    $actions =  '<div class="drodown">
                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <ul class="link-list-opt no-bdr">
                                    <li>
                                        <a class="dropdown-item" href="'. route('activation-urls.edit', $record). '" data-title="Edit Activation Url" data-toggle="tooltip" data-placement="top" title="Edit Activation Url">
                                            <em class="icon ni ni-edit"></em><span>Edit</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="delete" href="javascript:void(0)" data-table="activation_urls_table" data-method="get" data-url="' .route('activation-urls.destroy', $record). '" data-toggle="tooltip" data-placement="top" title="Delete Activation Url">
                                            <em class="icon ni ni-trash"></em><span>Delete</span>
                                        </a>
                                    </li>
                                </ul></div></div>';
                return $actions;
            })
            ->addColumn('title', function ($record) {
                return '<a href="'. route('activation-urls.edit', $record) .'" class="link" data-toggle="tooltip" data-placement="top" title="Edit Activation Url">'.$record->registrationPage->title.'</a>';
            })
            ->addColumn('ticket', function ($record) {
                $tickets = '';
                if ($record->tickets) {
                    foreach ($record->tickets as $ticket) {
                        $tickets .= '<span class="badge badge-light ml-1">'. $ticket->amount .'</span>';
                    }
                }
                return $tickets;
            })
            ->addColumn('url', function ($record) {
                return $record->url;
            })
            ->addColumn('user', function ($record) {
                return getFullName($record->user);
            })
            ->addColumn('status', function ($record) {
                return '<span class="badge badge-'.statusClasses($record->status).'">'. ucfirst($record->status) .'</span>';
            })
            ->rawColumns(['title', 'ticket', 'url', 'user', 'status', 'actions'])
            ->addIndexColumn()->make(true);
    }

    // public function registrationPageGroups(Request $request)
    // {
    //     $groups = Group::where('status', 'active')->get();
    //     $registrationPage = RegistrationPage::with('groups')->findOrFail($request->registration_page_id);
    //     $selected_groups = $registrationPage->groups->pluck('id')->toArray();
    //     $data = '';
    //     foreach ($groups as $group) {
    //         $checked = false;
    //         if (in_array($group->id, $selected_groups)) {
    //             $checked = 'checked';
    //         }
    //         $data .= '<div class="col-lg-2">
    //                         <div class="custom-control custom-control-md custom-checkbox custom-control pb-2">
    //                             <input type="checkbox" class="custom-control-input" value="'. $group->id .'" id="'. $group->id .'" name="groups[]" '.$checked.'>
    //                             <label class="custom-control-label text-capitalize" for="'. $group->id .'">'. $group->name .'</label>
    //                         </div>
    //                     </div>';
    //     }
    //     return $data;
    // }
}
