@extends('layouts.navigation')

@section('content')
        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Velonic</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Base UI</a></li>
                                        <li class="breadcrumb-item active">Cards</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Create Role</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-8 col-lg-3">

                            <!-- Simple card -->
                            <div class="card d-block">
                               
 <div class="card-body" >

                        <div class="btn-group btn-group-sm pull-right" role="group">
                                <a href="{{ route('roles.index') }}" class="btn btn-primary" style="border-radius: 25px;" title="role list">
                                <i class="fas fa-list"></i>Lists
                                </a>
                            </div>
                         
    </div>
<div class="card-body" >
        <div class="row">
        <div class="col-lg-12">
            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif


<form method="POST" action="{{ route('roles.store') }}" accept-charset="UTF-8" id="create_role_form" name="create_role_form" class="form-horizontal">
            {{ csrf_field() }}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-4">
        <div class="form-group">
            <strong><h5 style="color:#215467; font-weight: bold; font-family:serif;">Name</h5></strong>
            <input class="form-control" name="name" type="text" id="name" value="" minlength="1" maxlength="255" placeholder="Enter name...">    
        </div>
    </div>
</br></br></br></br>
    <div class="col-xs-12 col-sm-12 col-lg-12">
        <div class="form-group">
            <strong><h5 style="color:#215467; font-weight: bold; font-family:serif;">Permmision</h5></strong>

            @php
    $counter = 0; // Counter variable to keep track of iterations
    @endphp

    @foreach($permission as $value)
        @if($counter % 12 === 0)
            <div class="row">
        @endif
        

    <div class="col-md-3">
        <input type="checkbox" id="{{ $value->id }}" name="permission[]" value="{{ $value->name }}">
        <label for="permission" style="color:#215467; font-size: 14px; font-family:system-ui;"> {{ $value->name }}</label><br>
    </div>

    @php
    $counter++;
    @endphp

    @if($counter % 12 === 0 || $loop->last)
        </div>
        <br>
        <div class="">
            <div class="col-lg-3"></div>
        </div>
    @endif
@endforeach
        </div>
    </div>
            <div class="form-group"> 
                    <div class="col-md-offset-2 col-md-10">
                    <button type="button" class="btn btn-secondary"style=" border-radius:25px" id="selectAllBtn" onclick="toggleCheckboxes()">select all</button>
                        <input class="btn btn-primary" type="submit" style="border-radius: 25px;" value="create">
                  </div>
            </div>
        
</div>
</div>
</form>
</div>
</div>
</div>
        
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div><!-- end col -->
</div> <!-- content -->

 <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>
    <script>
    function toggleCheckboxes() {
        var checkboxes = document.querySelectorAll('input[name="permission[]"]');
        var selectAllBtn = document.getElementById('selectAllBtn');
        var checked = false;

        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                checked = true;
                return;
            }
        });

        checkboxes.forEach(function(checkbox) {
            checkbox.checked = !checked;
        });

        if (checked) {
            selectAllBtn.textContent = 'sellect all';
        } else {
            selectAllBtn.textContent = 'deselect all';
        }
    }
</script>
</body>

@endsection