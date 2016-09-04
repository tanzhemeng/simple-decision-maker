@extends('layouts.master')

@section('title', 'Page Title')

@section('content')

<div class="h-full bg-info">
	<div class="container">
		<h1 class="m-y-lg">Simple Decision Maker</h1>

		<p class="lead">Question: {{ $question }}</p>

		@foreach ($choices as $key => $choice)
			@if ($key === $selected)
			<p class="text-danger"><strong>Choice {{ $key }}: {{ $choice }}</strong></p>
			@else
			<p>Choice {{ $key }}: {{ $choice }}</p>
			@endif
		@endforeach

		<form action="{{ action('QuestionController@getAnswer') }}" method="GET">
			<input type="hidden" name="question" value="{{ $question }}">

			@foreach ($choices as $key => $choice)
			<input type="hidden" name="choice[{{ $key }}]" value="{{ $choice }}">
			@endforeach

			<div class="form-group m-t-lg">
				<button type="submit" class="btn btn-primary">Ask again</button>
				<a href="{{ url('/') }}" class="btn btn-default">Ask another question</a>
			</div>
		</form>
	</div>
</div>

@endsection

@push('scripts')

@endpush