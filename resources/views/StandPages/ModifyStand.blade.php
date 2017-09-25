@extends('layouts.mainTmp')
@section('content')
<h1 class='header h1'>Edit Stand</h1>
{!! Form::open(['action'=>['standController@update',$stand->id],'method'=>'POST','onsubmit'=>'return confirm("Press OK to Update")']) !!}
<div class='form-group'>
    <label class="form-check-label">Event ID</label>
    <select name="event_id" class="form-group-lg custom-select">    
        @foreach($stand->events()->get() as $e)
        <option name="{{ $e->id }}" value="{{$e->id}}">{{$e->name}}</option>
        @endforeach
    </select>
</div>
<div class='form-group'>
    {{Form::label('title','Code')}}
    {{ Form::text ('code',$stand->code,['class'=>'form-control','placeholder'=>'code']) }}
</div>
<div class='form-group'>
    {{Form::label('title','Price')}}
    {{Form::text('price',$stand->price,['class'=>'form-control','placeholder'=>'Price'])}}
</div> 
{{Form::submit('Modify Stand',['class'=>'btn btn-primary'])}}
{{Form::hidden('_method','PUT')}}
{!!Form::close()!!}
@endsection