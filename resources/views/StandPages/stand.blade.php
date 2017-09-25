@extends('layouts.mainTmp')
@section('content')
<div class="container">
    <div class="row row-offcanvas row-offcanvas-right">
        <div class=" col col-lg-12 col-md-24">
            <div class="jumbotron">
                <h1>Check for your Stand</h1>
            </div>
            <div class="container row row-offcanvas">
                @if(count($stand) > 0)
                @foreach($stand as $s)
                    <div class="col-md-4">
                        <h2>Stand:{{$s->code}}</h2>
                        <p>{{$s->price}}</p>
                        <p><a class="btn btn-secondary" href="/VirtualExbo/public/stand/{{$s->id}}" role="button">Head for Registeration &raquo;</a></p>
                    </div>
                @endforeach
                @else
                    <h1>No stands for this event</h1>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection