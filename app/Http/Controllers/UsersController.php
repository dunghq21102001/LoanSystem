<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function showAllAddress()
    {
        $results = DB::table('addressee')->get();
        // $Lresults = DB::table('lender')->get();
        return response()->json($results);
    }
    public function showBorrowers()
    {
        $Bresults = DB::table('borrower')->get();
        // $Lresults = DB::table('lender')->get();
        return response()->json($Bresults);
    }
    public function showLenders()
    {
        $Lresults = DB::table('lender')->get();
        // if (isEmpty($Lresults)) {
        //     return response('No lender here', 200);
        // }
        return response()->json($Lresults);
    }
    public function showOneBorrower($id)
    {
        return response()->json(DB::table('borrower')->where('ID', '=', $id)->get());
    }
    public function showOneLender($id)
    {
        return response()->json(DB::table('lender')->find($id));
    }
    public function createAddress(Request $request)
    {
        $address = DB::table('Addressee')->insert(
            $request->all()
        );
        return response()->json($address, 201);
    }

    public function createBorrower(Request $request)
    {
        $author = DB::table('borrower')->insert(
            $request->all()
        );
        return response()->json($author, 201);
    }
    public function createLender(Request $request)
    {
        $author = DB::table('lender')->insert(
            $request->all()
        );
        return response()->json($author, 201);
    }
    public function deleteBorrower($id)
    {
        DB::table('borrower')->delete($id);
        return response('Deleted Successfully', 200);
    }
    public function deleteLender($id)
    {
        DB::table('lender')->delete($id);
        return response('Deleted Successfully', 200);
    }

    public function updateBorrower($id, Request $request)
    {
        $author = DB::table('borrower')
            ->where('ID', $id)
            ->update($request->all());

        return response()->json($author, 200);
    }
    public function updateLender($id, Request $request)
    {
        $author = DB::table('lender')
            ->where('ID', $id)
            ->update($request->all());
        return response()->json($author, 200);
    }
}
