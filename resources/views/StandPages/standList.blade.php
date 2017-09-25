@extends('layouts.mainTmp')
@section('content')
<h1 style="text-align: center;">Events' Stands</h1>
<hr>
<div>
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col">
            @if(count($stands)>0)
            <table class="table table-striped table-inverse table-bordered">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Price</th>
                        <td>Actions</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stands as $s)
                    <tr>
                        <td>{{$s->code}}</td>
                        <td>{{$s->price}}</td>
                        <td><a class="btn btn-primary" href="/VirtualExbo/public/stand/{{$s->id}}/edit" role="button">Edit Stand</a></td>
                        <td>
                            {!!Form::open(['action'=>['standController@destroy',$s->id],'method'=>'POST','onsubmit'=>'return confirm("Press OK to Delete")'])!!}
                            {{Form::submit('Delete Stand',['class'=>'btn btn-danger'])}}
                            {{Form::hidden('_method','DELETE')}}
                            {!!Form::close()!!}
                        </td>
                    </tr>
                </tbody>
                @endforeach
            </table>
            @else 
            <h1>NO Stands Exist So add one now</h1>
            <a class="btn btn-primary" href="/VirtualExbo/public/stand/create">Create Stand</a>
            @endif
        </div>
    </div>
</div>
@endsection
