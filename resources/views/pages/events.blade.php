@extends('layouts.mainTmp')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="jumbotron" style="text-align: center;">
                <h1>Welcome to Virto Exbo Event!</h1>
                <p>In this page you see the available Exbiditions accross the world.</p>
            </div>
            <div class="row row-offcanvas">
                @foreach($allEvents as $e)
                <div class="col jumbotron" style="margin-left:15px;text-align:center;">
                    <div class="row">
                        <h6 class="col">Name</h6>
                        <h6 class="col">:</h6>
                        <label class="h6 label col">{{$e->name}}</label>
                    </div>
                    <br>
                    <div class="row">
                        <h6 class="col">Location</h6>
                        <h6 class="col">:</h6>
                        <label class="h6 label col">{{$e->location}}</label>
                    </div>
                    <br>
                    <div class="row">
                        <h6 class="col">Date</h6>
                        <h6 class="col">:</h6>
                        <label class="h6 label col">{{$e->date}}</label>
                    </div>
                    <br>
                    <div class="row">
                        <h6 class="col">Hosted by</h6>
                        <h6 class="col">:</h6>
                        <label class="h6 label col">{{$e->user->name}}</label>
                    </div>
                    
                    <br>
                    <!-- ana 3mlt kda 34an ana b3ml check 3la el current user w myEvents controller wa5ed permission auth -->
                    @if(Auth::guest())
                        <p><a class="btn btn-secondary col" href="/VirtualExbo/public/myEvents/{{$e->id}}" role="button">Be Our Guest &raquo;</a></p>
                    @elseif(!Auth::user()->hasRole('Admin'))
                        <p><a class="btn btn-secondary col" href="/VirtualExbo/public/myEvents/{{$e->id}}" role="button">Be Our Guest &raquo;</a></p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection