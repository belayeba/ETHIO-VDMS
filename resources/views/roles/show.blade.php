@extends('layouts.main')
@section('pagetitle')
Role show
@endsection
@section('content')

<div class="card" style="border-radius: 25px; box-shadow: 0px 2px 20px 5px rgba(22, 119, 170, 0.4); width: 800px;">
                <div class="card"  style="border-radius: 25px;">
                    <div class="card-header" style="border-radius: 25px;">
                            <h4 class="d-flex justify-content-center" style="color:#215467; font-weight: bold; font-family:serif;">{{ $role->name }}</h4>
        </span>
        @can('role-list')
            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('roles.index') }}" class="btn btn-primary" style="border-radius: 25px;" title="የተመዘገቡ ሚናዎች">
                <i class="fas fa-list"></i>
                </a>
            </div>
            @endcan
    </div>
</div>


<div class="card-body" >
        <div class="row">
        <div class="col-lg-6">
        <div class="form-group">
            <strong _ngcontent-ng-c3262625476=""><h6 style="color: #215467; font-weight: bold; font-family:sans-serif;">Name:</strong>
            {{ $role->name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong _ngcontent-ng-c3262625476=""><h6 style="color: #215467; font-weight: bold; font-family:sans-serif;">Permissions:</strong>
            @if(!empty($rolePermissions))
                @foreach($rolePermissions as $v)
                    <label class="label label-success" >{{ $v->name }},</label>
                @endforeach
            @endif
        </div>
    </div>
</div>
</div>
</div>
@endsection