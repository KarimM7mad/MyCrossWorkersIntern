@extends('layouts.mainTmp')
@section('content')
<div class="container" Style="background-color: grey">
    <br>
    <div class="row">
        <h4 class="col">Stand Code</h4>
        <h4 class="col">:</h4>
        <label class="h4 label col"> {{$stand->code}}</label>
    </div>
    <br>
    <div class="row">
        <h4 class="col">Stand Price</h4>
        <h4 class="col">:</h4>
        <label class="h4 label col">{{$stand->price}}</label>
    </div>
    <br>
    {!! Form::open(['action'=>['standController@update',$stand->id],'method'=>'POST']) !!}
    {{Form::hidden('_method','PUT')}}
    {{Form::submit('Register Stand &raquo;',['class'=>'btn btn-primary col'])}}
    {!!Form::close()!!}
    <br>
</div>
@endsection