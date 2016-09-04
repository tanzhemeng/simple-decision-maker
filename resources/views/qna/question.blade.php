@extends('layouts.master')

@section('title', 'Page Title')

@section('content')

<div class="h-full bg-info">
	<div class="container">
		<h1 class="m-y-lg">Simple Decision Maker</h1>

		<form action="{{{ action('QuestionController@submitForm') }}}" method="POST" id="questionForm">
			{{ csrf_field() }}

			<div class="form-group">
				<label class="control-label">Question</label>
				<input type="text" name="question" class="form-control" placeholder="Enter your question here" id="question">
			</div>

			<fieldset id="choices">
				<div class="form-group">
					<label class="control-label">Choices (Lay down your choices)</label>
					<input type="text" name="choice[1]" class="form-control" placeholder="Choice 1" id="choice1">
				</div>

				<div class="form-group">
					<input type="text" name="choice[2]" class="form-control" placeholder="Choice 2" id="choice2">
				</div>
			</fieldset>

			<div class="form-group">
				<button type="button" class="btn btn-default" id="addButton"><i class="glyphicon glyphicon-plus"></i> choice</button>
			</div>

			<div class="form-group m-t-lg">
				<button type="submit" class="btn btn-primary btn-lg pull-right" data-loading-text="Getting answer..." autocomplete="off">Get answer</button>
			</div>
		</form>
	</div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/qna.js') }}"></script>
@endpush