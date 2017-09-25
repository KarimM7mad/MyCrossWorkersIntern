@extends('layouts.mainTmp')
@section('content')
<h1 style="text-align:center;">My Events</h1>
<hr>
<div>
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col">
            <div class="jumbotron" style="text-align:center;">
                <h1>Your current Events</h1>
                <p>Here are The Events You Created!.</p>
            </div>
            @if(count($allEvents)>0)
            <table class="table table-striped table-inverse table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Location</th>
                        <th>date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allEvents as $e)
                    <tr>
                        <td>{{$e->name}}</td>
                        <td>{{$e->location}}</td>
                        <td>{{$e->date}}</td>
                        <td><a class="btn btn-primary" href="/VirtualExbo/public/myEvents/{{$e->id}}/edit" role="button">Edit Event</a></td>
                        <td> 
                            {!!Form::open(['action'=>['MyEventsController@destroy',$e->id],'method'=>'POST','onsubmit'=>'return confirm("Press OK to Delete")'])!!}
                            {{Form::hidden('_method','DELETE')}}
                            {{Form::submit('Delete Event',['class'=>'btn btn-danger'])}}
                            {!!Form::close()!!}
                        </td>
                        <td>
                            {!!Form::open(['action'=>['standController@show',$e->id],'method'=>'GET'])!!}
                            {{Form::submit('Show Stands',['class'=>'btn btn-primary'])}}
                            {!!Form::close()!!}
                        </td>
                    </tr>
                </tbody>
                @endforeach
            </table>
            @else 
            <h1>NO Events Exist so Create one now</h1>
                <a class="btn btn-primary" href="/VirtualExbo/public/myEvents/create" role="button">Create an Event</a>
            @endif
        </div>
    </div>
</div>
@endsection
