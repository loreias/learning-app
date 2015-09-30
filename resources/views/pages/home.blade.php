@extends('layout')


@section('content')

	<h1>home page</h1>
	{{-- {{ $test1 }} --}}
	<br>
	{!! $test1 !!}

	
	@foreach ( $test2 as $test)
		<h2>{{$test}}</h2><br>
		
	@endforeach

@stop