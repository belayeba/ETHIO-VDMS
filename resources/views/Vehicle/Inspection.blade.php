@extends('layouts.navigation')
@section('content')

<style>
.badge {
    font-size: 0.9em;
    padding: 0.3em 0.5em;
    margin-right: 0.2em;
}
.remove-tag {
    cursor: pointer;
    margin-left: 0.3em;
}
</style>

<div class="content-page">
        <div class="content">

        @if(Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show col-lg-5" 
                role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Error - </strong> {!! session('error_message') !!}
            </div>
            @endif
            
            @if(Session::has('success_message'))
            <div class="alert alert-primary alert-dismissible text-bg-primary border-0 fade show col-lg-5"
                role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong> Success- </strong> {!! session('success_message') !!} 
            </div>
            @endif

        <!-- Start Content-->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title">Vehicle Inspection</h4>
                    </div>
                    <div class="card-body"> 
                        <form method="POST" action="{{route('inspection.store')}}" enctype="multipart/form-data">
                            @csrf

                            <div id="progressbarwizard">
                                <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                    <li class="nav-item">
                                        <a href="#account-2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                            <i class=" ri-list-check-3 fw-normal fs-20 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">Inspection Form</span>
                                        </a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a href="#profile-tab-2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                            <i class="ri-timer-fill fw-normal fs-20 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">Duration</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#finish-2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                            <i class=" ri-map-pin-fill fw-normal fs-20 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">Location</span>
                                        </a>
                                    </li> -->
                                </ul>

                                <div class="tab-content b-0 mb-0">

                                <div id="bar" class="progress mb-3" style="height: 7px;">
                                    <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success"></div>
                                </div>
                            
                                <div class="tab-pane" id="account-2">
                                <div class="row">
                                    <div class="position-relative ">
                                        <div class="position-relative mb-3">
                                            <label class="form-label" for="validationTooltip02">Select Vehicle</label>
                                            <select class="form-control" id="department_id" name="vehicle_id">
                                                <option value="">Select Vehicle</option>
                                                    @foreach ($vehicle as $vec )
                                                    <option value="{{$vec->vehicle_id}}">
                                                        {{$vec->plate_number}}
                                                    </option>
                                                    @endforeach
                                            </select>
                                        </div> 
                                    </div>
                                    {{-- <div class="position-relative mb-3"> --}}
                                        <div class="position-relative mb-3">
                                            <label class="form-label" for="validationTooltip02">Insert Inspection Image</label></br>
                                            <input type="file" name="inspection_image" class="form-control">  
                                        </div> 
                                    {{-- </div> --}}
                                    <div class="text-center mb-4">
                                        <label class="form-label fw-bold fs-4" for="spareParts" style="color: #333;">
                                            Spare Parts
                                        </label>
                                    </div>
                                    @foreach($parts->where('type', 'normal_part') as $part)
                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-3">
                                            <strong>{{ $part->name }}</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input yes-checkbox" id="yes_{{ $loop->index }}" name="damaged_parts[{{ $part->id }}]" value="1" data-row="{{ $loop->index }}">
                                                        <label class="form-check-label" for="yes_{{ $loop->index }}">Yes</label>
                                                        <input type="text" name="damage_descriptions[{{ $part->id }}]" id="input_{{ $loop->index }}" class="d-none quantity-notes" placeholder="How many" data-row="{{ $loop->index }}">
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-check form-checkbox-danger">
                                                        <input type="checkbox" class="form-check-input none-checkbox" id="no_{{ $loop->index }}" name="damaged_parts[{{ $part->id }}]" value="0" data-row="{{ $loop->index }}">
                                                        <input type="hidden" name="parts[{{ $part->id }}]" value="{{ $part->vehicle_parts_id }}">
                                                        <label class="form-check-label" for="no_{{ $loop->index }}">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                
                                <div class="text-center mb-4">
                                    <label class="form-label fw-bold fs-4" for="spareParts" style="color: #333;">
                                        Vehicle Parts
                                    </label>
                                </div>


                                @foreach($parts->where('type', 'spare_part') as $part)
                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-3">
                                            <strong>{{ $part->name }}</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input ok-checkbox" id="ok_{{ $loop->index }}" name="damaged_parts[{{ $part->id }}]" value="1" data-row="{{ $loop->index }}">
                                                        <input type="hidden" name="parts[{{ $part->id }}]" value="{{ $part->vehicle_parts_id }}">
                                                        <label class="form-check-label" for="ok_{{ $loop->index }}">OK</label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-check form-checkbox-danger">
                                                        <input type="checkbox" class="form-check-input damaged-checkbox" id="damaged_{{ $loop->index }}" name="damaged_parts[{{ $part->id }}]" value="0" data-row="{{ $loop->index }}">
                                                        <label class="form-check-label" for="damaged_{{ $loop->index }}">Damaged</label>
                                                        <input type="text" name="damage_descriptions[{{ $part->id }}]" id="notes_{{ $loop->index }}" class="d-none damaged-notes" placeholder="Add Description" data-row="{{ $loop->index }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        const checkboxGroups = [
                                            {
                                                primaryClass: '.ok-checkbox',
                                                oppositeClass: '#damaged_{index}',
                                                inputClass: 'input.damaged-notes[data-row="{index}"]',
                                                showInput: false
                                            },
                                            {
                                                primaryClass: '.damaged-checkbox',
                                                oppositeClass: '#ok_{index}',
                                                inputClass: 'input.damaged-notes[data-row="{index}"]',
                                                showInput: true
                                            },
                                            {
                                                primaryClass: '.yes-checkbox',
                                                oppositeClass: '#no_{index}',
                                                inputClass: '#input_{index}',
                                                showInput: true
                                            },
                                            {
                                                primaryClass: '.none-checkbox',
                                                oppositeClass: '#yes_{index}',
                                                inputClass: '#input_{index}',
                                                showInput: false
                                            }
                                        ];
                                
                                        function handleCheckboxChange(checkbox, group) {
                                            const rowIndex = checkbox.dataset.row;
                                            const oppositeCheckbox = document.querySelector(group.oppositeClass.replace('{index}', rowIndex));
                                            const inputField = document.querySelector(group.inputClass.replace('{index}', rowIndex));
                                
                                            if (checkbox.checked) {
                                                oppositeCheckbox.checked = false;
                                                if (group.showInput) {
                                                    inputField.classList.remove('d-none');
                                                    inputField.required = true;
                                                } else {
                                                    inputField.classList.add('d-none');
                                                    inputField.value = '';
                                                    inputField.required = false;
                                                }
                                            } else if (group.showInput) {
                                                inputField.classList.add('d-none');
                                                inputField.value = '';
                                                inputField.required = false;
                                            }
                                        }
                                
                                        checkboxGroups.forEach(group => {
                                            const checkboxes = document.querySelectorAll(group.primaryClass);
                                            checkboxes.forEach(checkbox => {
                                                checkbox.addEventListener('change', function () {
                                                    handleCheckboxChange(this, group);
                                                });
                                            });
                                        });
                                    });
                                </script>
                                
                                    
                                </div>
                                    <ul class="list-inline wizard mb-0">
                                        <!-- <li class="next list-inline-item float-end">
                                            <a href="javascript:void(0);" class="btn btn-info">Add More Info <i class="ri-arrow-right-line ms-1"></i></a>
                                        </li> -->
                                        <li class="next list-inline-item float-end">
                                            <button type="submit" class="btn btn-info">Submit<i class="ri-arrow-right-line ms-1"></i></button>
                                        </li>
                                    </ul>
                                </div> 

                                <div class="tab-pane" id="profile-tab-2">
                                  
                                        <ul class="pager wizard mb-0 list-inline">
                                            <li class="previous list-inline-item">
                                                <button type="button" class="btn btn-light"><i class="ri-arrow-left-line me-1"></i> Back to Account</button>
                                            </li>
                                            <li class="next list-inline-item float-end">
                                                <button type="button" class="btn btn-info">Add More Info <i class="ri-arrow-right-line ms-1"></i></button>
                                            </li>
                                        </ul>
                                </div> 
                                
                                <div class="tab-pane" id="finish-2">
                                <ul class="pager wizard mb-0 list-inline">
                                            <li class="previous list-inline-item">
                                                <button type="button" class="btn btn-light"><i class="ri-arrow-left-line me-1"></i> Back to Account</button>
                                            </li>
                                            <li class="next list-inline-item float-end">
                                                <button type="button" class="btn btn-info">Add More Info <i class="ri-arrow-right-line ms-1"></i></button>
                                            </li>
                                        </ul>
                                    </div> 
                                </div>   
                            </div>

                        </form> 

                    </div> <!-- end card-->
             </div> <!-- end col-->
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Roll.no</th>
                                <th>Plate number</th>
                                <th>Inspection Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        @foreach($inspections as $data) 
                        <tbody>
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$data->vehicle->plate_number}}</td>
                                <td>{{$data->inspection_date}}</td>
                                <td> 
                                    <button type="button" class="btn btn-info rounded-pill" title="Inspect" id="assignBtn-{{$loop->iteration}}">Show</button>
                                  
                                    <input type="hidden" name="id" id="IdSelection-{{$loop->iteration}}" value="{{$data->inspection_id}}" id="vehicleselection">
                                    <button type="button" class="btn btn-danger rounded-pill reject-btn" data-bs-toggle="modal" data-bs-target="#confirmationModal-{{ $loop->index }}" title="Reject"><i class=" ri-close-circle-fill"></i></button>
                                </td>
                            </tr>
                        </tbody>
                        <script>
                            document.getElementById('assignBtn-{{$loop->iteration}}').addEventListener('click', function() {
                            var selectedCarId = document.getElementById('IdSelection-{{$loop->iteration}}').value;
                                
                                // Perform an Ajax request to fetch data based on the selected car ID
                                $.ajax({
                                    url: "{{ route('inspection.show.specific') }}",
                                    type: 'post',
                                    headers: {
                                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                    },
                                    data: { id: selectedCarId },
                                    success: function(response) {
                                        $('#staticaccept-{{$loop->iteration}}').modal('show');
                                        var cardsContainer = document.getElementById('inspectionCardsContainer-{{$loop->iteration}}');
                                        cardsContainer.innerHTML = ''; // Clear previous cards
                        
                                        if (response.status === 'success' && Array.isArray(response.data) && response.data.length > 0) {
                                            // Create the table
                                            var Image = response.data[0].image_path;
                                            var imageUrl = Image ? "{{ asset('storage/vehicles/Inspections/') }}" + '/' + Image : null;    
                                            var inspectedBy = response.data[0].inspected_by;
                                            var createdAt = new Date(response.data[0].created_at).toLocaleDateString('en-US', {
                                                year: 'numeric',
                                                month: '2-digit',
                                                day: '2-digit'
                                            });
                                        // Create a section to display "Inspected By" and "Created At" at the top right corner
                                            var infoSection = document.createElement('div');
                                            infoSection.className = 'd-flex justify-content-end mb-4'; // Flexbox to align right and add margin-bottom
                                            infoSection.innerHTML = `
                                                <p><strong>Inspected By:</strong> ${inspectedBy} </br>
                                                <strong>Created At:</strong> ${createdAt}</br>
                                               <strong>Image:</strong> 
                                               ${ imageUrl 
                                                    ? `<a href="${imageUrl}" target="_blank"> Click to View </a>` 
                                                    : 'No image'
                                                }
                                            `;
                                            cardsContainer.appendChild(infoSection); // Append the info section before the table
                        
                                            var table = document.createElement('table');
                                            table.className = 'table table-striped'; // Add Bootstrap classes for styling
                                            table.innerHTML = `
                                                <thead>
                                                    <tr>
                                                        <th>Part Name</th>
                                                        <th>Is Damaged / Is Available</th>
                                                        <th>Damage Description / Quantity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            `;
                        
                                            response.data.forEach(function(inspection) {
                                                var row = document.createElement('tr');
                                                row.innerHTML = `
                                                    <td>${inspection.part_name}</td>
                                                    <td>${inspection.is_damaged ? 'No' : 'Yes'}</td>
                                                    <td>${inspection.damage_description ? inspection.damage_description : 'N/A'}</td>
                                                `;
                                                table.querySelector('tbody').appendChild(row); // Append row to the table body
                                            });
                        
                                            cardsContainer.appendChild(table);
                        
                                        } else {
                                            // Handle the case where no data is available
                                            cardsContainer.innerHTML = '<p>No inspection data available.</p>';
                                        }
                                    },
                                    error: function() {
                                        var cardsContainer = document.getElementById('inspectionCardsContainer');
                                        cardsContainer.innerHTML = ''; // Clear previous cards
                                        cardsContainer.innerHTML = '<p>No inspection data available at the moment. Please check the Plate number!</p>';
                                    }
                                });
                            });
                        </script>
                        <!-- this is for the assign  modal -->
                        <div class="modal fade" id="staticaccept-{{$loop->iteration}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                     
                                        <div class="modal-header">
                                                                                                            
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div> <!-- end modal header -->
                                        <div class="modal-body">
                                            <div class="row mt-3" id="inspectionCardsContainer-{{$loop->iteration}}" class="table table-striped"> 
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-secondary"  data-bs-dismiss="modal" aria-label="Close">close</button>
                                        </div> <!-- end modal footer -->
                                    </div>                                                              
                                </div> <!-- end modal content-->
                            </div> <!-- end modal dialog-->
                         <!-- reject Alert Modal -->
                        <div class="modal fade" id="confirmationModal-{{ $loop->index }}" tabindex="-1" role="dialog"
                         aria-labelledby="confirmationModalLabel"aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('inspection.delete', ['inspectionId' => $data->inspection_id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="request_id" id="request_id">
                                        <div class="modal-body p-4">
                                            <div class="text-center">
                                                <i class="ri-alert-line h1 text-danger"></i>
                                                <h4 class="mt-2">Warning</h4>
                                                <h5 class="mt-3">
                                                    Are you sure you want to DELETE this Inspection Form?</br> This action
                                                    cannot be
                                                    undone.
                                                </h5>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger"
                                                    id="confirmDelete">Yes,
                                                    DELETE</button>
                                            </div>
                                        </div>
                                    </form>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                         </div><!-- /.modal -->
                    @endforeach
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
    </div><!-- end col-->
</div> 

    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>

    <!-- Datatables js -->
    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    

    <!-- Datatable Demo Aapp js -->
    <script src="{{ asset('assets/js/pages/datatable.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
@endsection