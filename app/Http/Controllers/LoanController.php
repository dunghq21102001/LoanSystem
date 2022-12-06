<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; //get current time
use function PHPUnit\Framework\isEmpty;

class LoanController extends Controller
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
    public function showAllLoansRequest()
    {
        $results = DB::table('Loan Request')->get();
        return response()->json($results);
    }
    public function showALoansRequest($id)
    {
        return response()->json(DB::table('loan request')->find($id));
    }

    public function createLoansRequest(Request $request)
    {
        $loanRequest = DB::table('loan request')->insert(
            $request->all()
        );
        return response()->json($loanRequest, 201);
    }

    public function deleteLoansRequest($id)
    {
        DB::table('loan request')->delete($id);
        return response('Deleted Successfully', 200);
    }


    public function updateLoansRequest($id, Request $request)
    {
        $loanRequest = DB::table('loan request')
            ->where('ID', $id)
            ->update($request->all());
        return response()->json($loanRequest, 200);
    }

    public function showAllLoansRequestOfLender()
    {
        $results = DB::table('loan request_lender')->get();
        return response()->json($results);
    }

    public function createLoanRequestOfLender($id, Request $request)
    {
        //create loan request for lender in DB
        DB::table('loan request_lender')->insert(
            [
                'Amount' => $request->input('amount'),
                'Loan Request_ID' => $id,
                'Lender_ID' => $request->input('lenderId')
            ]
        );
    }

    public function deleteLoanRequestOfLender($id)
    {
        DB::table('loan request_lender')->delete($id);
        return response('Deleted Successfully', 200);
    }

    //after lender change amount of loan request and borrowers accept with that amount
    public function finalLoan($id, Request $request)
    {
        $amount = DB::table('Loan Request')
            ->select(DB::raw('Amount'))
            ->where('ID', $id)->pluck('Amount');

        $borrowerId = DB::table('Loan Request')
            ->select(DB::raw('Borrower_ID'))
            ->where('ID', $id)->pluck('Borrower_ID');
        // $deadline = DB::table('Loan Request')
        //     ->select(DB::raw('Deadline'))
        //     ->where('ID', $id)->get()->pluck('Deadline');
        
        $amount = str_replace('[', '', $amount);
        $amount = str_replace(']', '', $amount);
        $borrowerId = str_replace('[', '', $borrowerId);
        $borrowerId = str_replace(']', '', $borrowerId);
        // $currentTime = Carbon::now()->date; //current time


        $currentTime = date('Y-m-d H:i:s');

        //create repayment in DB
        DB::table('Repayment')->insert(
            [
                'Date' => $currentTime,
                'Amount' => $amount
            ]
        );

        //create repayment in DB
        DB::table('Deadline')->insert(
            [
                'Agreed_Date' => $currentTime
            ]
        );

        //create loan in DB
        DB::table('Loan')->insert(
            [
                'Date' => $currentTime,
                'Repayment_Date' => $currentTime,
                'Deadline_Agreed_Date' => $currentTime,
            ]
        );

        //create lender_borrower in DB
        DB::table('lender_borrower')->insert(
            [
                'Percentage' => 1,
                'Borrower_ID' => $borrowerId,
                'Lender_ID' => $request->input('lid'),
                'Loan_Date' => $currentTime
            ]
        );
    }
}
