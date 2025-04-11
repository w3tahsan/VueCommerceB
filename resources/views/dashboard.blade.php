@extends('admin')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Welcome , {{ Auth::user()->name }}</h3>
            </div>
        </div>
    </div>
</div>
@endsection