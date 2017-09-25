@extends('layouts.mainTmp')
@section('content')
<h1 class='header h1'>Edit Event</h1>
{!! Form::open(['action'=>['MyEventsController@update',$event->id],'method'=>'POST','onsubmit'=>'return confirm("Press OK to Update")']) !!}
<div class='form-group'>
    {{Form::label('title','Name')}}
    {{Form::text('name',$event->name,['class'=>'form-control','placeholder'=>'Name'])}}
</div>
<div class='form-group'>
    {{Form::label('title','Location')}}
    {{Form::text('location',$event->location,['class'=>'form-control','placeholder'=>'Location'])}}
</div> 
<div class='form-group'>
    {{Form::label('title','Exbidition day')}}
    {{Form::date('date', $event->date)}}
</div> 
{{Form::hidden('_method','PUT')}}
{{Form::submit('Submit',['class'=>'btn btn-primary'])}}
{!!Form::close()!!}
@endsection