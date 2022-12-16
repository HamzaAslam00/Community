<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\RegistrationPage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($registrationPageId)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($registrationPageId)
    {
        return view('tickets.modal', compact('registrationPageId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $registrationPageId)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'amount' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        try{
            DB::beginTransaction();
            $ticket = Ticket::create([
                'registration_page_id' => $registrationPageId,
                'title' => $request->title,
                'amount' => $request->amount,
                'description' => $request->description,
                'status' => $request->status,
            ]);
            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Ticket added successfully.',
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
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit($registrationPageId, Ticket $ticket)
    {
        return view('tickets.modal', compact('ticket', 'registrationPageId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $registrationPageId, Ticket $ticket)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'amount' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        try{
            DB::beginTransaction();
            $ticket->update([
                'title' => $request->title,
                'amount' => $request->amount,
                'description' => $request->description,
                'status' => $request->status,
            ]);
            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Ticket updated successfully.',
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
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy($registrationPageId, Ticket $ticket)
    {
        try 
        {
            $ticket->delete();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Ticket Deleted successfully'
            ], JsonResponse::HTTP_OK);
        } 
        catch (\Exception $exception) 
        {
            return response()->json([
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR); 
        }
    }
    
    public function dataTable ($registrationPageId) {
        $tickets = RegistrationPage::findOrFail($registrationPageId)->tickets;
        return Datatables::of($tickets)
            ->addColumn('actions', function ($record) use($registrationPageId) {
                $actions = '';
                    $actions =  '<div class="drodown">
                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <ul class="link-list-opt no-bdr">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-act="ajax-modal" data-method="get" data-action-url="'. route('admin.registration-pages.tickets.edit', [$registrationPageId, $record]). '" data-title="Edit Ticket" data-toggle="tooltip" data-placement="top" title="Edit Ticket">
                                            <em class="icon ni ni-edit"></em><span>Edit</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="delete" href="javascript:void(0)" data-table="tickets_table" data-method="get" data-url="' .route('admin.registration-pages.tickets.destroy', [$registrationPageId, $record]). '" data-toggle="tooltip" data-placement="top" title="Delete Ticket">
                                            <em class="icon ni ni-trash"></em><span>Delete</span>
                                        </a>
                                    </li>
                                </ul></div></div>';
                return $actions;
            })
            ->addColumn('title', function ($record) use($registrationPageId) {
                return '<a href="javascript:void(0)" class="link" data-act="ajax-modal" data-method="get"
                                data-action-url="'. route('admin.registration-pages.tickets.edit', [$registrationPageId, $record]). '" data-title="Edit Ticket"
                                data-toggle="tooltip" data-placement="top" title="Edit Ticket">'.$record->title.'</a>';
            })
            ->addColumn('amount', function ($record) use($registrationPageId) {
                return '$'.$record->amount;
            })
            ->addColumn('status', function ($record) {
                return '<span class="badge badge-'.statusClasses($record->status).'">'. ucfirst($record->status) .'</span>';
            })
            ->rawColumns(['title', 'amount', 'status', 'actions'])
            ->addIndexColumn()->make(true);
    }
}