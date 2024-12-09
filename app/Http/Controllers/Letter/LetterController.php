<?php

namespace App\Http\Controllers\Letter;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Letter;
use App\Models\Letter\LetterModel;

class LetterController extends Controller
{
  
    public function index()
    {
        $letters = LetterModel::with(['preparedBy', 'reviewedBy', 'approvedBy', 'acceptedBy'])->get();
        return response()->json($letters);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'letter_file' => 'required|pdf|max:2048', // Ideally a file upload with validation rules
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error_message',
            "Attach drafts of the letter",
    );
        }
        $the_letter = '';    
        if ( $request->hasFile( 'letter_file') ) {
            $file = $request->file( 'letter_file' );
            $storagePath = storage_path( 'app/public/Letters' );
            if ( !file_exists( $storagePath ) ) {
                mkdir( $storagePath, 0755, true );
            }

            $the_letter = time() . '_' . $file->getClientOriginalName();
            $file->move( $storagePath, $the_letter );
        }
        $letter = LetterModel::create([
            'letter_file' => $the_letter,
            'prepared_by' => Auth::id(),
            'status' => 0, // Default status
        ]);
        return response()->json($letter, 201);
    }

    public function update(Request $request, $id)
    {
        $letter = LetterModel::find($id);

        if (!$letter) {
            return redirect()->back()->with('error_message',
            "Warning! Letter Not Found",
           );
        }
        if($letter->reviewed_by != null)
           {
            return redirect()->back()->with('error_message',
                        "Warning! You are denied the service",
                );
           }
        $validator = Validator::make($request->all(), [
            'letter_file' => 'required|pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error_message',
                        "please upload pdf file",
                );
        }
        $the_letter = '';    
        if ( $request->hasFile( 'letter_file') ) {
            $file = $request->file( 'letter_file' );
            $storagePath = storage_path( 'app/public/Letters' );
            if ( !file_exists( $storagePath ) ) {
                mkdir( $storagePath, 0755, true );
            }

            $the_letter = time() . '_' . $file->getClientOriginalName();
            $file->move( $storagePath, $the_letter );
        }
        $letter->update($request->only([
            'letter_file'=> $the_letter
        ]));

        return response()->json($letter);
    }

 
    public function review(Request $request, $id)
    {
        $letter = LetterModel::find($id);

        if (!$letter) {
            return redirect()->back()->with('error_message',
                        "The Letter Not found",
                );
        }

        $validator = Validator::make($request->all(), [
            'reviewed_by_reject_reason' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error_message',
                        "Reason Required",
                );
        }

        $letter->update([
            'reviewed_by' => Auth::id(),
            'reviewed_by_reject_reason' => $request->reviewed_by_reject_reason,
        ]);

        return response()->json($letter);
    }


    public function approve(Request $request, $id)
    {
        $letter = LetterModel::find($id);

        if (!$letter) {
            return redirect()->back()->with('error_message',
                        "The Letter Not found",
                );
        }
        if ($letter->reviewed_by == null) {
            return redirect()->back()->with('error_message',
                        "It is not reviewed yet",
                );
        }
        $validator = Validator::make($request->all(), [
            'approved_by_reject_reason' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error_message',
                        "Approved Reason Required",
                );
        }
        $letter->update([
            'approved_by' => Auth::id(),
            'approved_by_reject_reason' => $request->approved_by_reject_reason,
        ]);

        return response()->json($letter);
    }


    public function accept(Request $request, $id)
    {
        $letter = LetterModel::find($id);

        if (!$letter) {
                    return redirect()->back()->with('error_message',
                    "The Letter Not found",
               );
        }

        $validator = Validator::make($request->all(), [
            'accepted_by_reject_reason' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error_message',
                        "Reason Required",
                );
        }

        $letter->update([
            'accepted_by' => Auth::id(),
            'accepted_by_reject_reason' => $request->accepted_by_reject_reason,
        ]);

        return response()->json($letter);
    }

 
    public function show($id)
    {
        $letter = LetterModel::with(['preparedBy', 'reviewedBy', 'approvedBy', 'acceptedBy'])->find($id);

        if (!$letter) {
            return redirect()->back()->with('error_message',
                        "The Letter Not found",
                );
        }

        return response()->json($letter);
    }

 
    public function destroy($id)
    {
        $letter = LetterModel::find($id);

        if (!$letter) {
            return redirect()->back()->with('error_message',
                        "The Letter Not found",
                );
        }
        if ($letter->accepted_by != null) {
            return redirect()->back()->with('error_message',
                        "You cannot delete the letter",
                );
        }
        $letter->delete();
          return redirect()->back()->with('success_message',
                        "The letter deleted successfully",
                );
    }
}
