<?php

namespace App\Http\Controllers\Letter;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Letter;
use App\Models\Letter\LetterModel;

class LetterManagement extends Controller
{

  
    public function index()
    {
        // $letters = LetterModel::with(['preparedBy', 'reviewedBy', 'approvedBy', 'acceptedBy'])->get();
        // return response()->json($letters);
        return view('Letter.request');
    }

    public function FetchLetter()
    {
        $data = LetterModel::with(['preparedBy', 'reviewedBy', 'approvedBy', 'acceptedBy'])->get();
                
                return datatables()->of($data)
                ->addIndexColumn()

                ->addColumn('counter', function($row) use ($data){
                    static $counter = 0;
                    $counter++;
                    return $counter;
                })

                ->addColumn('preparedBy', function ($row) {
                    return $row->preparedBy->first_name . ' ' . $row->preparedBy->last_name;
                })

                ->addColumn('date', function ($row) {
                    return $row->created_at->format('d/m/Y');
                })

                ->addColumn('actions', function ($row) {
                    $actions = '';                    
                    
                        $actions .= '<button class="btn btn-info rounded-pill view-btn"
                        data-reviewedBy="' . ($row->reviewedBy ? $row->reviewedBy->first_name .' '. $row->reviewedBy->last_name : null) . '"
                        data-approvedBy="' . ($row->approvedBy ? $row->approvedBy->first_name .' '. $row->approvedBy->last_name : null) . '"
                        data-department="' . ($row->department ? $row->department : null) . '"
                        data-acceptedBy="' . ($row->acceptedBy ? $row->acceptedBy->first_name .' '. $row->acceptedBy->last_name : null) . '"
                        data-image="' . $row->letter_file . '"
                        title="edit"><i class="ri-eye-line"></i></button>';

                    if ($row->reviewed_by == null) {
                        $actions .= '<button class="btn btn-secondary rounded-pill update-btn" title="edit"><i class="ri-edit-line"></i></button>';
                        $actions .= '<button class="btn btn-danger rounded-pill reject-btn" title="edit"><i class=" ri-close-circle-fill"></i></button>';
                    }

                    return $actions;
                })

                ->rawColumns(['counter','preparedBy','date','actions'])
                ->toJson();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'letter_file' => 'required|mimes:pdf|max:2048', // Ideally a file upload with validation rules
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error_message',
            "Attach drafts of the letter",);
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
        return redirect()->back()->with('success_message', "Success!",);
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

        return redirect()->back()->with('success_message', "Success!",);
    }

    public function review_page()
    {
        return view('Letter.review');
    }

    public function FetchLetterApprove(Request $request)
    {
        $data_drawer_value = $request->input('customDataValue');
     
        if($data_drawer_value == 1){
            $data = LetterModel::with(['preparedBy', 'reviewedBy', 'approvedBy', 'acceptedBy'])->get();
        } 
        if($data_drawer_value == 2){
            $data = LetterModel::with(['preparedBy', 'reviewedBy', 'approvedBy', 'acceptedBy'])
            ->whereNull('reviewed_by_reject_reason')
            ->whereNotNull('reviewed_by')
            ->get();

        } 
        if($data_drawer_value == 3){
            $data = LetterModel::with(['preparedBy', 'reviewedBy', 'approvedBy', 'acceptedBy'])
            ->whereNull('approved_by_reject_reason')
            ->whereNotNull('approved_by')
            ->where('department', 'Purchase')
            ->get();

        }
        if($data_drawer_value == 4){
            $data = LetterModel::with(['preparedBy', 'reviewedBy', 'approvedBy', 'acceptedBy'])
            ->whereNull('approved_by_reject_reason')
            ->whereNotNull('approved_by')
            ->where('department', 'Finance')
            ->get();

        } 

        return datatables()->of($data)
        ->addIndexColumn()

        ->addColumn('counter', function($row) use ($data){
            static $counter = 0;
            $counter++;
            return $counter;
        })

        ->addColumn('preparedBy', function ($row) {
            return $row->preparedBy->first_name . ' ' . $row->preparedBy->last_name;
        })

        ->addColumn('date', function ($row) {
            return $row->created_at->format('d/m/Y');
        })

        ->addColumn('status', function ($row) use ($data_drawer_value) {
            if ($data_drawer_value == 1) {
                if ($row->reviewed_by !== null && $row->reviewed_by_reject_reason === null) {
                    return 'ACCEPTED';
                } elseif ($row->reviewed_by !== null && $row->reviewed_by_reject_reason !== null) {
                    return 'REJECTED';
                }
                return 'PENDING';
            } 
            elseif ($data_drawer_value == 2) {
                if ($row->approved_by !== null && $row->approved_by_reject_reason === null) {
                    return 'ACCEPTED';
                } elseif ($row->approved_by !== null && $row->approved_by_reject_reason !== null) {
                    return 'REJECTED';
                }
                return 'PENDING';
            } 
            elseif ($data_drawer_value == 3) {
                if ($row->department === 'Purchase' && $row->accepted_by !== null && $row->accepted_by_reject_reason === null) {
                    return 'ACCEPTED';
                } elseif ($row->department === 'Purchase' && $row->accepted_by_reject_reason !== null) {
                    return 'REJECTED';
                }
                return 'PENDING';
            } 
            elseif ($data_drawer_value == 4) {
                if ($row->department === 'Finance' && $row->accepted_by !== null && $row->accepted_by_reject_reason === null) {
                    return 'ACCEPTED';
                } elseif ($row->department === 'Finance' && $row->accepted_by_reject_reason !== null) {
                    return 'REJECTED';
                }
                return 'PENDING';
            } 
        })

        ->addColumn('actions', function ($row) use ($data_drawer_value){
            $actions = '';                    
            
                $actions .= '<button class="btn btn-info rounded-pill view-btn"
                data-reviewedBy="' . ($row->reviewedBy ? $row->reviewedBy->first_name . ' ' . $row->reviewedBy->last_name : null) . '"            
                data-approvedBy="' . ($row->approvedBy ? $row->approvedBy->first_name . ' ' . $row->approvedBy->last_name : null) . '"
                data-department="' . ($row->department ? $row->department : null) . '"
                data-acceptedBy="' . ($row->acceptedBy ? $row->acceptedBy->first_name . ' ' . $row->acceptedBy->last_name : null) . '"
                data-image="' . $row->letter_file . '"
                title="edit"><i class="ri-eye-line"></i></button>';
            if ($data_drawer_value == 1) {
                if ($row->reviewed_by == null) {
                    $actions .= '<button class="btn btn-primary rounded-pill accept-btn"  data-id="' . $row->letter_id. '" title="edit"><i class="ri-checkbox-circle-line"></i></button>';
                    $actions .= '<button class="btn btn-danger rounded-pill reject-btn"   data-id="' . $row->letter_id. '" title="edit"><i class=" ri-close-circle-fill"></i></button>';
                }
            }
            if ($data_drawer_value == 2) {
                if ($row->approved_by == null) {
                    $actions .= '<button class="btn btn-primary rounded-pill accept-btn"  data-id="' . $row->letter_id. '" title="edit"><i class="ri-checkbox-circle-line"></i></button>';
                    $actions .= '<button class="btn btn-danger rounded-pill reject-btn"   data-id="' . $row->letter_id. '" title="edit"><i class=" ri-close-circle-fill"></i></button>';
                }
            }
            if ($data_drawer_value == 3) {
                if ($row->accepted_by == null) {
                    $actions .= '<button class="btn btn-primary rounded-pill accept-btn"  data-id="' . $row->letter_id. '" title="edit"><i class="ri-checkbox-circle-line"></i></button>';
                    $actions .= '<button class="btn btn-danger rounded-pill reject-btn"   data-id="' . $row->letter_id. '" title="edit"><i class=" ri-close-circle-fill"></i></button>';
                }
            }
            if ($data_drawer_value == 4) {
                if ($row->accepted_by == null) {
                    $actions .= '<button class="btn btn-primary rounded-pill accept-btn"  data-id="' . $row->letter_id. '" title="edit"><i class="ri-checkbox-circle-line"></i></button>';
                    $actions .= '<button class="btn btn-danger rounded-pill reject-btn"   data-id="' . $row->letter_id. '" title="edit"><i class=" ri-close-circle-fill"></i></button>';
                }
            }

            return $actions;
        })

        ->rawColumns(['counter','preparedBy','date','status','actions'])
        ->toJson();

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
            'reviewed_by_reject_reason' => 'nullable|string',
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

        return redirect()->back()->with('success_message', "Success!",);
    }


    public function approve_page()
    {
        return view('Letter.approved');
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
            'department' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error_message',
                        "Please fill the Required Fields",
                );
        }
        
        $letter->update([
            'approved_by' => Auth::id(),
            'department' => $request->department,
            'approved_by_reject_reason' => $request->approved_by_reject_reason,
        ]);

        return redirect()->back()->with('success_message', "Success!",);
    }


    public function accept_page_purchase()
    {
        return view('Letter.purchase');
    }

    public function accept_page_finance()
    {
        return view('Letter.finance');
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
