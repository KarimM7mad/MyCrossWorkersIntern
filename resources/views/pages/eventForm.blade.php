@extends('layouts.mainTmp')
@section('content')
<h1 class='header h1' style="text-align: center;">Event Creation Form<hr></h1>
<a href="/VirtualExbo/public/myEvents" class="btn btn-secondary">Go Back</a>
{!!Form::open(['action'=>'MyEventsController@store','method'=>'POST']) !!}
<div class='form-group'>
    {{Form::label('title','Name')}}
    {{Form::text('name','',['class'=>'form-control','placeholder'=>'Name'])}}
</div>
<div class='form-group'>
    {{Form::label('title','Location')}}
    {{Form::text('location','',['class'=>'form-control','placeholder'=>'Location'])}}
</div> 
<div class='form-group'>
    {{Form::label('title','Exbidition day')}}
    {{Form::date('date', \Carbon\Carbon::now())}}
</div>
{{Form::submit('Submit',['class'=>'btn btn-primary'])}}
{!!Form::close()!!}
@endsection