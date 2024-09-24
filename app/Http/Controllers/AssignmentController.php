<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ReferencingStyle;
use App\Models\AcademicLevel;
use App\Models\Assignment;
use App\Models\Attachment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AddOrderRequest;

class AssignmentController extends Controller
{
    function index(){
        $title='Orders';
        return view('orders',compact('title'));
    }
    function serviceList(){
        $services=Service::get(['id','name']);
        $referencing_style=ReferencingStyle::get(['id','name']);
        $academic_level=AcademicLevel::get(['id','name']);
        return response()->json([
            'data' => [
                'services' => $services,
                'academic_level' => $academic_level,
                'referencing_style' => $referencing_style,
            ],
        ], 200);
    }

    function addOrder(AddOrderRequest $request){
        $previousAssignment=342315;
        try {
            $order=Assignment::create([
                'user_id'=>Auth::id(),
                'assignments_id'=>'LA' . (Assignment::count()+1+$previousAssignment),
                'subject'=> $request->subject,
                'service'=> $request->service,
                'university'=> $request->university,
                'referencingStyle'=> $request->referencingStyle,
                'educationLevel'=> $request->educationLevel,
                'deadline'=> Carbon::parse($request->deadline),
                'pages'=> $request->pages,
                'specificInstruction'=> $request->specificInstruction
              ]);


                if (isset($request->attachments) && is_array($request->attachments)) {
                    foreach ($request->attachments as $attachmentPath) {
                        $attachment = new Attachment();
                        $attachment->assignment_id = $order->id;
                        $attachment->path = $attachmentPath;
                        $attachment->save();
                    }
                }
                
            //   }
            return response()->json([
                'success' => true,
                'message' => 'Assignment submitted successfully!'
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
       
    }
    function assignmentList(User $user,$is_completed){
        try{
            $assignments = DB::table('assignments')
            ->where('user_id', $user->id)
            ->where('is_completed', $is_completed)
            ->join('services', 'assignments.service', '=', 'services.id') 
            ->join('referencing_styles', 'assignments.referencingStyle', '=', 'referencing_styles.id') 
            ->join('academic_levels', 'assignments.educationLevel', '=', 'academic_levels.id') 
            ->select('assignments.*',  'services.name as service', 
            'referencing_styles.name as referencingStyle', 'academic_levels.name as educationLevel' ) 
            ->orderBy('assignments.id', 'desc')
            ->get();
        return response()->json([
            'data' => [
                'success' => true,
                'assignments' => $assignments,
            ],
        ], 200);
    } catch(Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 400);
    }
    }
    function orderList(){
        try{
            $assignments = DB::table('assignments')
            ->join('services', 'assignments.service', '=', 'services.id') 
            ->join('referencing_styles', 'assignments.referencingStyle', '=', 'referencing_styles.id') 
            ->join('academic_levels', 'assignments.educationLevel', '=', 'academic_levels.id') 
            ->join('users', 'assignments.user_id', '=', 'users.id') 
            ->select('assignments.*', 'services.name as service', 
            'referencing_styles.name as referencingStyle', 'academic_levels.name as educationLevel','users.country_code as country_code', 'users.contact as contact' ) 
            ->orderBy('assignments.id', 'desc')
            ->get();
        return response()->json([
            'data' => [
                'success' => true,
                'assignments' => $assignments,
            ],
        ], 200);
    } catch(Exception $e) {
        dd($e);
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 400);
    }
    }
    function assignmentStatusList(){
        try{
            $assignmentStatuses = DB::table('assignment_statuses')->get(['id','name','color']);
        return response()->json([
            'data' => [
                'success' => true,
                'assignmentStatuses' => $assignmentStatuses,
            ],
        ], 200);
    } catch(Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 400);
    }
    }

    public function show($id) {
        

            
        try {
            $assignment = DB::table('assignments')->where('assignments.id', $id) // Use 'assignments.id'
    ->join('services', 'assignments.service', '=', 'services.id') 
    ->join('referencing_styles', 'assignments.referencingStyle', '=', 'referencing_styles.id') 
    ->join('academic_levels', 'assignments.educationLevel', '=', 'academic_levels.id') 
    ->join('users', 'assignments.user_id', '=', 'users.id') 
    ->select(
        'assignments.*', 
        'services.name as service', 
        'referencing_styles.name as referencingStyle', 
        'academic_levels.name as educationLevel',
        'users.country_code as country_code', 
        'users.contact as contact',
        'users.name as user_name'
    ) 
    ->orderBy('assignments.id', 'desc')
    ->first();
    return response()->json(['succes' => true, 'data'=>$assignment], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json(['error' => 'Unable to fetch assignment details'], 500);
        }
    }
    

    function AssignmentCounts(Request $request){
        $inprogress = Assignment::where('user_id', Auth::id())
        ->where('is_completed', 0)->count();
        $completed = Assignment::where('user_id', Auth::id())
        ->where('is_completed', 1)->count();
        $total=$inprogress+$completed;
        return response()->json(['succes' => true, 'data'=>['total'=>$total,'inprogress'=>$inprogress,'completed'=>$completed]], 200);
    }
    
}
