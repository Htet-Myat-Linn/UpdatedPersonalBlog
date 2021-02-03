@extends('layouts.indexLayout')
@section('background_image')
'{{asset('/img/background.jpg')}}'
@endsection
@section('content')
<div class="container">
	
	<div class="row" id="article">
		@if(auth()->id() ==1)
			<div class="col-lg-12 col-md-10 mx-auto">
			<a href="/article/create"><button class="btn btn-outline-light" style="border-radius:25px;">Create New Article</button></a>
			<br><hr class="white-hr">
		</div>
		@endif
		<div class="card-deck row row-cols-3 row-cols-md-3">
			@if($articleData)
				@foreach($articleData as $values)
					<div class="col mb-4">
						<div class="card  custom-card">
							<img class="card-img-top custom-card-image" src="{{ asset('/img/'.$values->images)}}" alt="Photo is not supported in your browser">
							<div class="card-body">
								<h5 class="card-title">{{$values->article_name}}</h5>
								<p class="card-text">{{ $values->category->category}}</p>
								<p class="card-text">{{ $values->description}}.....<br><a href="/article/{{ $values->id}}">Details &raquo</a></p>
								
							</div>
							<p class="card-text custom-card-tag"><small class="text-muted">Last updated: {{$values->created_at->diffForHumans()}} by Aphrodite</small></p>
						</div>
					</div>
				@endforeach
			@endif
		</div>

	    <div class="col-lg-12 col-md-10 mx-auto">
			<br><hr class="white-hr">
	    	{{$articleData->links()}}
	   	</div>
	</div>
@endsection

	
	
