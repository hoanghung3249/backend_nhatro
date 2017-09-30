<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<div class="well container"  style="margin-top:150px">
	@if(Session::has('message'))
		<p class="alert alert-info">{{ Session::get('message') }}</p>
	@endif
</div>

<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>