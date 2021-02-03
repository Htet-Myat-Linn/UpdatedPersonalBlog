@extends('layouts.indexLayout')
@section('background_image')
'{{asset('/img/detail.jpg')}}'
@endsection
@section('content')
<div class="container white-content">
	
	<div class="row" id="article">
	    
		    <div class="col-lg-8 col-md-10 mx-auto">
		        <div class="post-preview">
			          
			        <h2 class="post-title">
			             {{$article->article_name}}
					</h2>
					<br>
			        <h4 class="post-subtitle">
			              Category: {{ $article->category->category}}
					</h4>
					<br>
			        @if($article->images)
			        <img style="width: 80%;margin-left:50px;border-radius:20px;" src="{{ asset('/img/'.$article->images)}}" alt="This photo is not supported.">
			        @endif
			        <p>{!! $article->content !!}</p>
			        @if($article->contentImages)
			        <img style="width: 80%;margin-left:50px;" src="{{ asset('/img/'.$article->contentImages)}}" alt="This photo is not supported.">
			        @endif
			        <p class="post-meta">Posted by APHRODIT3
			            {{$article->created_at->diffForHumans()}}</p>
			    
				    @if(auth()->id()==1)
					    <a href="/article/{{$article->id}}/edit"><button class="btn btn-outline-light" style="float: left;border-radius:15px;">Edit</button></a>

						<form method="POST" style="margin-left: 100px;">
								@csrf
								{{method_field('DELETE')}}
								<a href="/article/{{$article->id}}"><button class="btn btn-outline-light" style="border-radius:15px;">Delete</button></a>
						</form>
				    @endif
					<br>
					
					<ul class="list-group mb-2 .list-group-flush">
						<li class="list-group-item-info  dark-mode " style="list-style: none;padding:20px;"><h3 class="white-content">Comment
						<span class="count-comment">({{ count($article->comments) }})</span>
					</h3></li>
						
							@foreach($article->comments as $values)

								<li class="list-group-item comment-row dark-mode">
									<div class="card comment-style dark-mode">
										<b class="comment-username white-content">{{$values->username}}</b>
										<p class="comment-content white-content">{{$values->content}}</p>
										<p class="comment-info white-content"><small class="text-muted">Last updated--->{{$values->created_at->diffForHumans()}}</small></p>
										
									</div>
								</li>
								
							@endforeach
						</li>
					</ul>
					@guest
					<h5><a href="{{route('register')}}">Please register or login for comment features.</a></h5>
					@else
						<form action="/comment/create/{{$article->id}}/{{$user->name}}" method="GET">
							@csrf
							<textarea  name="content" placeholder="Comment something for your expression..." style="width: 100%;height: 80px;"></textarea>
							<br><br>
							<input type="submit" value="Send" class="btn btn-outline-light" style="border-radius:15px;">
						</form>
					@endguest
				    <hr>
					

			    </div>
			</div>
</div>
	
		
@endsection

