@extends('layouts.navigation')

@section('content')
   
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
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Fuel Request</h4>
                </div>
                <div class="card-body"> 
                    <form action="{{route('store_fuel_request')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div id="progressbarwizard">
                            <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                <li class="nav-item">
                                    <a href="#account-2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                        <i class="ri-car-fill fw-normal fs-20 align-middle me-1"></i>
                                        <span class="d-none d-sm-inline">Request</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content b-0 mb-0">
                                <div id="bar" class="progress mb-3" style="height: 7px;">
                                    <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success"></div>
                                </div>
                                
                                <div class="tab-pane" id="account-2">
                                    <div class="row">
                                        <div class="position-relative mb-3">
                                            <div class="mb-6 position-relative" id="datepicker1">
                                                <label class="form-label">Type</label>
                                                <select class="form-select mb-3" name="vehicle_id">
                                                    <option selected>Open this select menu</option>
                                                    <option value="1">Monthly Fuel Request</option>
                                                    <option value="2">Other Fuel Request</option>
                                                 </select>
                                            </div>
                                        </div>   
                                            <div class="mb-3 position-relative">
                                                <label class="form-label">Select Month</label>
                                                <select class="form-select mb-3" name="month">
                                                <option value="">Select</option>    
                                                <option value="1">መስከረም</option>
                                                <option value="2">ጥቅምት</option>
                                                <option value="3">ኅዳር</option>
                                                <option value="4">ታህሣሥ</option>
                                                <option value="5">ጥር</option>
                                                <option value="6">የካቲት</option>
                                                <option value="7">መጋቢት</option>
                                                <option value="8">ሚያዝያ</option>
                                                <option value="9">ግንቦት</option>
                                                <option value="10">ሰኔ</option>
                                                <option value="11">ሐምሌ</option>
                                                <option value="12">ነሐሴ</option>
                                                <option value="13">ጳጉሜ</option>
                                            </select>
                                            </div>
                                        

                                        <div class="row mb-3 entry" >
                                            <div class="col-md-3">
                                                <div class="position-relative">
                                                    <label for="position-letter" class="form-label">Fuel</label>
                                                    <input id="Fuel_ammount"  class="form-control" placeholder="In Litter" type="number">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="position-relative">
                                                    <label for="driving-license" class="form-label">price</label>
                                                    <input id="fuel_price"  class="form-control" placeholder="In Birr" type="number">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="position-relative">
                                                    <label for="driving-license" class="form-label">Date</label>
                                                    <input id="fill_date"  class="form-control" placeholder="When" type="text">
                                                </div>
                                            </div>
                                             <script> 
                                                var currentYear = 2024;

                                                $('#fill_date').calendarsPicker({ 
                                                    calendar: $.calendars.instance('ethiopian', 'am'), 
                                                    pickerClass: 'myPicker', 
                                                    dateFormat: 'yyyy-mm-dd'                                                     
                                                    // defaultDate: ethiopianCalendar.newDate(currentYear, 02, 1),  // Set default date to 01 of the selected month
                                                    // showOnFocus: true,  // Ensure the picker shows on focus

                                                    // month: true
                                                });
                                             </script>

                                            <div class="col-md-3">
                                                <div class="position-relative">
                                                    <label for="driving-license" class="form-label">Attachment</label>
                                                    <input id="attachment" name="Driving_license" class="form-control" type="file">
                                                </div>
                                            </div>

                                        </div>

                                            <div class="d-flex flex-wrap gap-2 justify-content-center align-items-center">
                                                <button type="button" class="btn btn-primary rounded-pill" id="addItem">Add</button>
                                            </div>

                                        <div id="itemList"></div>
                                    </div>

                                    <ul class="list-inline wizard mb-0">
                                        <li class="next list-inline-item float-end">
                                            <button type="submit" class="btn btn-info">Submit</button>
                                        </li>
                                    </ul>
                                </div> 
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                    const addButton = document.getElementById('addItem');
                                    const itemList = document.getElementById('itemList');
                                    
                                    addButton.addEventListener('click', function() {
                                        const fuel = document.getElementById('Fuel_ammount').value;
                                        const fuelPrice = document.getElementById('fuel_price').value;
                                        const fillDate = document.getElementById('fill_date').value;
                                        const attachment = document.getElementById('attachment').value;
                                        const attachmentName = attachment.split('\\').pop();
                                        
                                        if (fuel && fuelPrice && fillDate && attachment) {
                                            const itemDiv = document.createElement('div');
                                            itemDiv.innerHTML = `
                                                <span>Fuel: ${fuel} litters &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Price: ${fuelPrice} birr &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date: ${fillDate} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Attachment: ${attachmentName}</span>
                                                <button class="removeItem">X</button>
                                            `;
                                            
                                            const fuelInput = document.createElement('input');
                                            fuelInput.type = 'hidden';
                                            fuelInput.name = 'fuel_amount[]';
                                            fuelInput.value = fuel;
                                            
                                            const priceInput = document.createElement('input');
                                            priceInput.type = 'hidden';
                                            priceInput.name = 'fuel_cost[]';
                                            priceInput.value = fuelPrice;
                                            
                                            const dateInput = document.createElement('input');
                                            dateInput.type = 'hidden';
                                            dateInput.name = 'fuiling_date[]';
                                            dateInput.value = fillDate;
                                            
                                            const attachmentInput = document.createElement('input');
                                            attachmentInput.type = 'hidden';
                                            attachmentInput.name = 'reciet_attachment[]';
                                            attachmentInput.value = attachment;

                                            itemDiv.classList.add('itemEntry');
                                            itemList.appendChild(itemDiv);
                                            itemList.appendChild(fuelInput);
                                            itemList.appendChild(priceInput);
                                            itemList.appendChild(dateInput);
                                            itemList.appendChild(attachmentInput);

                                            // Clear input fields after adding item
                                            document.getElementById('Fuel_ammount').value = '';
                                            document.getElementById('fuel_price').value = '';
                                            document.getElementById('fill_date').value = '';
                                            document.getElementById('attachment').value = '';
                                        }
                                    });

                                    itemList.addEventListener('click', function(e) {
                                        if (e.target.classList.contains('removeItem')) {
                                            const itemDiv = e.target.parentElement;
                                            itemDiv.remove();
                                        }
                                    });
                                });
                                </script>  
                            </div>   
                        </div>
                    </form> 

                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
        
                                
        <!-- Ebook List -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                <h4 class="header-title mb-0">Request List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="lms_table" class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Vehicle Plate</th>
                                    <th scope="col">Fuel Amount</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Table rows will be populated here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
         
    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel">Delete Confirmation</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center">Are you sure to delete ?</p>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <a id="delete_link" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

     
    
    <script>
        $(document).on('click', '#show_ai_text_generator', function () {
            var selected_template = $(this).data('selected_template');
            var ai_template = $('#ai_template');
            if (selected_template) {
                ai_template.val(selected_template);
                $('#ai_template').niceSelect('update');
            }
            $("#ai_text_generation_modal").modal('show');
        });

        $(document).on('change', '#ai_template', function (e) {
            let templateId = $(this).val();
            if (templateId == 1 || templateId == 11) {
                $('#titleDiv').addClass('d-none');
            } else {
                $('#titleDiv').removeClass('d-none');
            }
        });

        $('.dataTables_length label select').niceSelect();
        $('.dataTables_length label .nice-select').addClass('dataTable_select');
        $(document).on('click', '.dataTables_length label .nice-select', function () {
            $(this).toggleClass('open_selectlist');
        });
    </script>

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>
    <!-- App js -->
    <script src="assets/js/app.min.js"></script>
@endsection
