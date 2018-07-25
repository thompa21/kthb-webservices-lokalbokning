<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\tobject;
use Illuminate\View;
use DB; 

//TODO Validera inkommande data för create/update/delete
class ObjectController extends Controller
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
            'index', 'getObject',  'createObject', 'updateObject','deleteObject'
        ]]);
    }

    public function index(Request $request)
    {
        $query = DB::table('tobjects');

        if($request->input('Category')){
            $Category = $request->input('Category');
            $query = $query->when($Category, function($q) use ($Category) {
                return $q->where('Category', '=', $Category);
            });
        }

        if($request->input('limit')){
            $limit = $request->input('limit');
        } else {
            //visa 50 rader som default
            $limit = 50;
        }
        if (is_numeric($limit)){
            return response()->json($query->take($limit)->get());
        } else {
             //returnera endast alla om parameter limit = none. Men med paginering
            return response()->json($query->paginate(100));
        } 
    }

    public function getObject($id)
    {   
        if (is_numeric($id))
        {
            $object = tobject::find($id);
        }
        else
        {
            $column = 'Object';
            $object = tobject::where($column , '=', $id)->first();
        }
        return response()->json($object);
    }

    public function createEvent(Request $request)
    {
        $object = tobject::create($request->all());
        return response()->json($object);
    }

    public function updateEvent(Request $request, $id)
    {
        $object = tobject::find($id);
        //$user->name = $request->input('name');
        $object->save();
        return response()->json($object);   
    }

    public function deleteEvent($id){
        $object = tevent::find($id);
        $object->delete();
        return response()->json('deleted');
    }
   
}
?>