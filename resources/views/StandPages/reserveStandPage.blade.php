@extends('layouts.mainTmp')
@section('content')
<div class="container-fluid">
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col">
            <div class="jumbotron" style="text-align: center;">
                <h1>Stands Events</h1>
                <p>Reserve your spot.</p>
            </div>
            <div class="row row-offcanvas">
                @foreach($stand as $s)
                <div class="col col-lg-3 jumbotron" style="margin-left: 15px; text-align: center;">
                    <br>
                    <div class="row">
                        <h6 class="col">Stand Code</h6>
                        <h6 class="col">:</h6>
                        <label class="h4 label col"> {{$s->code}}</label>
                    </div>
                    <br>
                    <div class="row">
                        <h6 class="col">Stand Price</h6>
                        <h6 class="col">:</h6>
                        <label class="h4 label col">{{$s->price}}</label>
                    </div>
                    <br>
                    @if(Auth::user()->hasRole('normalUser') && $s->company_id == null)
                    <p><a class="btn btn-secondary col" href="/VirtualExbo/public/stand/{{$s->id}}" role="button">Register Now &raquo;</a></p>
                    @else
                    <div class="row">
                        <h6 class="col">Reserved by</h6>
                        <h6 class="col">:</h6>
                        <label class="h4 label col">{{$s->user->name}}</label>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection