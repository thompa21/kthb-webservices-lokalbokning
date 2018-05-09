<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\tevent;
use Illuminate\View;
use DB; 

//TODO Validera inkommande data för create/update/delete
class EventController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    

    public function __construct()
    {
        //definiera vilka anrop som behöver nyckel/autentisering
        $this->middleware('auth', ['only' => [
            'checkJWT', 'index', 'indextest', 'getEvent',  'createEvent', 'updateEvent','deleteEvent'
        ]]);
    }

    public function checkJWT($id)
    {   
        return response()->json("");
    }

    /*************************************************
     * 
     * Funktion som kan anropas utan några nycklar, 
     * se till att det inte finns några känsliga data
     * som returneras!
     * 
    *************************************************/
    public function noauthindex(Request $request)
    {
        $query = DB::table('tevents')
        ->join('tobjects', 'tevents.Event_Object', '=', 'tobjects.Object')
        ->select('Event_ID', 'Event_Object', 'Event_Title', 'Start_Date', 'Start_Time', 'End_Date', 'End_Time');
        
        
        if($request->input('fromDate') && $request->input('toDate')){
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');

            //För tester
            //$fromDate = "2018-05-16";
            //$toDate = "2018-05-16";
            
            //använd USE för att få med variabler
            $query
            ->where(function ($q) use($fromDate, $toDate) {
                $q->where('Start_Date', '>=', $fromDate)
                ->where('Start_Date', '<=', $toDate)
                ->where('tobjects.Category', '=', 'room'); //Ful lösning... Dubblera den här raden nedan för att att få med villkoret för join??
            })
            ->orWhere(function($q) use($fromDate, $toDate) {
                $q->where('End_Date', '>=', $fromDate)
                ->where('End_Date', '<=', $toDate)
                ->where('tobjects.Category', '=', 'room');	
            });
        }

        if($request->input('Event_Object')){
            $Event_Object = $request->input('Event_Object');
            $query = $query->when($Event_Object, function($q) use ($Event_Object) {
                return $q->where('Event_Object', '=', $Event_Object);
            });
        }
        if($request->input('limit')){
            $limit = $request->input('limit');
        } else {
            //visa 50 rader som default
            $limit = 50;
        }
        
        if (is_numeric($limit)){
            return response()->json($query->orderBy('Start_Time')->orderBy('End_Time')->take($limit)->get());
        } else {
             //returnera endast alla om parameter limit = none. Men med paginering
            return response()->json($query->orderBy('Start_Time')->orderBy('End_Time')->paginate(100));
        } 
    }

    /*************************************************
     * 
     * Funktion som kan anropas utan några nycklar, 
     * se till att det inte finns några känsliga data
     * som returneras!
     * 
    *************************************************/
    public function noauthgetEvent($id)
    {   
        if (is_numeric($id))
        {
            $user = tevent::find($id)->first(['Event_ID', 'Event_Object', 'Event_Title', 'Start_Date', 'Start_Time', 'End_Date', 'End_Time']);
        }
        else
        {
            $column = 'Event_Title';
            $user = tevent::where($column , '=', $id)->first(['Event_ID', 'Event_Object', 'Event_Title', 'Start_Date', 'Start_Time', 'End_Date', 'End_Time']);
        }
        return response()->json($user);
    }

    public function index(Request $request)
    {
        $query = DB::table('tevents');
        
        /*
        if($request->input('fromDate')){
            $fromDate = $request->input('fromDate');
            $query = $query->when($fromDate, function($q) use ($fromDate) {
                return $q
                    ->where('Start_Date', '>=', $fromDate);
                    //->where('End_Date', '>=', $fromDate);
            });
        }

        if($request->input('toDate')){
            $toDate = $request->input('toDate');
            $query = $query->when($toDate, function($q) use ($toDate) {
                return $q
                    ->where('Start_Date', '<=', $toDate);
            });
        }
        */
        if($request->input('fromDate') && $request->input('toDate')){
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            
            //använd USE för att få med variabler
            $query->where(function ($q) use($fromDate, $toDate) {
                $q->where('Start_Date', '>=', $fromDate)
                    ->where('Start_Date', '<=', $toDate);
            })->orWhere(function($q) use($fromDate, $toDate) {
                $q->where('End_Date', '>=', $fromDate)
                    ->where('End_Date', '<=', $toDate);	
            });
        }

        if($request->input('Event_Object')){
            $Event_Object = $request->input('Event_Object');
            $query = $query->when($Event_Object, function($q) use ($Event_Object) {
                return $q->where('Event_Object', '=', $Event_Object);
            });
        }

        if($request->input('limit')){
            $limit = $request->input('limit');
        } else {
            //visa 50 rader som default
            $limit = 50;
        }
        if (is_numeric($limit)){
            return response()->json($query->orderBy('Start_Date')->orderBy('Start_Time')->take($limit)->get());
        } else {
             //returnera endast alla om parameter limit = none. Men med paginering
            return response()->json($query-orderBy('Start_Date')->orderBy('Start_Time')->paginate(100));
        } 
    }

    public function indextest(Request $request)
    {
        $query = DB::table('tevents');
        
        if($request->input('fromDate') && $request->input('toDate')){
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            
            //använd USE för att få med variabler
            $query->where(function ($q) use($fromDate, $toDate) {
                $q->where('Start_Date', '>=', $fromDate)
                    ->where('Start_Date', '<=', $toDate);
            })->orWhere(function($q) use($fromDate, $toDate) {
                $q->where('End_Date', '>=', $fromDate)
                    ->where('End_Date', '<=', $toDate);	
            });
        }

        if($request->input('Event_Object')){
            $Event_Object = $request->input('Event_Object');
            $query = $query->when($Event_Object, function($q) use ($Event_Object) {
                return $q->where('Event_Object', '=', $Event_Object);
            });
        }

        if($request->input('limit')){
            $limit = $request->input('limit');
        } else {
            //visa 50 rader som default
            $limit = 50;
        }
        if (is_numeric($limit)){
            return response()->json($query->orderBy('Start_Date')->orderBy('Start_Time')->take($limit)->get());
        } else {
             //returnera endast alla om parameter limit = none. Men med paginering
            return response()->json($query-orderBy('Start_Date')->orderBy('Start_Time')->paginate(100));
        } 
    }

    public function getEvent($id)
    {   
        if (is_numeric($id))
        {
            $user = tevent::find($id);
        }
        else
        {
            $column = 'Event_Title';
            $user = tevent::where($column , '=', $id)->first();
        }
        return response()->json($user);
    }

    public function createEvent(Request $request)
    {
        $user = tevent::create($request->all());
        return response()->json($user);
    }

    public function updateEvent(Request $request, $id)
    {
        $user = tevent::find($id);
        $user->name = $request->input('name');
        $user->level = $request->input('level');
        $user->email = $request->input('email');
        $user->save();
        return response()->json($user);   
    }

    public function deleteEvent($id){
        $user = tevent::find($id);
        $user->delete();
        return response()->json('deleted');
    }
   
}
?>