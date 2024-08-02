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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                        <li class="breadcrumb-item active">Data Tables</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Data Tables</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="header-title">Role Table</h4> 
                                    <div class="btn-group btn-group-sm pull-right" role="group">
                                                <a href="{{ route('roles.create') }}" class="btn btn-success" class="btn btn-success btn-round" style="font-weight: italic; border-radius: 35px;" title="add role"><i class=" ri-add-fill"></i></a>     
                                            </div>  
                                </div>
                                              
                           
                                            
                                <div class="card-body">
                                @if(count($roles) == 0)
                                                <div class="panel-body text-center">
                                                    <h4>there is no role registerd.</h4>
                                                </div>
                                            @else
                                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>ROll</th>
                                                <th>Name</th>
                                                <th>Permmission</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                               @foreach ($roles as $key => $role)
                                                        <tr>
                                                            <td style="color: black;  font-family:system-ui">{{ ++$i }}</td>
                                                            <td style="color: black;  font-family:system-ui">{{ $role->name }}</td>
                                                            <td style="color: black;  font-family:system-ui">
                                                            @if(!empty($rolePermissions))
                                                                @foreach($rolePermissions as $v)
                                                                @if($v->role_id==$role->id)
                                                                    {{ $v->name }},
                                                                @endif
                                                                @endforeach
                                                            @endif
                                                            </td>
                                                            <td style=" text-align:center;">

                                                                <form method="POST" action="{!! route('roles.destroy', $role->id) !!}" accept-charset="UTF-8">
                                                                <input name="_method" value="DELETE" type="hidden">
                                                                {{ csrf_field() }}

                                                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                                                      
                                                                        <a href="{{ route('roles.show',$role->id) }}" class="btn btn-info" title="Show"><i class="ri-eye-fill"></i></a>
                                                                        

                                                                        @if ($role->name !== 'Admin')
                                                                        
                                                                        
                                                                                <a href="{{ route('roles.edit',$role->id) }}" class="btn btn-primary" title="Edit"><i class=" ri-edit-fill"></i> </a>
                                                                            
                                                                       

                                                                        
                                                                            <button type="submit" class="btn btn-danger" title="Delete" onclick="return confirm(&quot;Are you sure you want to delete?&quot;)">
                                                                            <i class="ri-delete-bin-7-fill"></i>
                                                                            </button>
                                                                      

                                                                    @endif
                                                                        
                                                                    </div>

                                                                </form>
                                                                
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            
                                </div> <!-- end row-->
                                                {!! $roles->render() !!}
                                        
                                        
                                            @endif
                                     
                                </div> <!-- end col -->
@endsection