@extends('layouts.mainTmp')
@section('content')
<h1 class='header h1' style="text-align: center;">Create Stand Form</h1>
<hr>
<a class="btn btn-secondary" href="/VirtualExbo/public/myEvents">Go Back</a>
@if(count($events)>0)
{!!Form::open(['action'=>'standController@store','method'=>'POST']) !!}
<div class='form-group' style="text-align:center;">
    <label class="form-check-label" >Event Name</label>
    <select name="event_id" class="form-group-lg custom-select" >    
        @foreach($events as $e)
        <option name="{{ $e->id }}" value="{{$e->id}}">{{$e->name}}</option>
        @endforeach
    </select>
</div>
<div class='form-group'>
    {{Form::label('title','Code')}}
    {{Form::text('code','',['class'=>'form-control','placeholder'=>'code'])}}
</div>
<div class='form-group'>
    {{Form::label('title','Price')}}
    {{Form::text('price','',['class'=>'form-control','placeholder'=>'Price'])}}
</div> 
{{Form::submit('Create Stand',['class'=>'btn btn-primary'])}}
{!!Form::close()!!}
@else
    <h1 class="danger" style="text-align:center;">No Events Exist</h1>
    <h2 style="text-align:center;">Create One through here </h2><a class="btn btn-primary" href="/VirtualExbo/public/myEvents/create">Create Event</a>
@endif

@endsection
