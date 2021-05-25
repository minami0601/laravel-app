@extends('layouts.app')

@section('content')

 <div class="center jumbotron bg-warning">

        <div class="text-center text-white">
            <h1>YouTubeまとめ × SNS</h1>
        </div>

    </div>
    
    <div class="text-right h4">
        @if(Auth::check())
            {{ Auth::user()->name }}
        @endif
        
    </div>
    @include('commons.tabs',['movies'=>$movies])
        <h2 class="mt-5">Movies</h2>

        <div class="movies row mt-5 text-center">
    
    @foreach ($movies as $key => $movie)
        
        @php
            $user=$movie->user;
            
            if($movie){
            
                    $key_name = config('app.key_name');
                    $get_api_url = "https://www.googleapis.com/youtube/v3/videos?id=$movie->url&key=$key_name&part=snippet";
                    $json = file_get_contents($get_api_url);
        
                    if($json){
                        $getData = json_decode( $json , true);
                        if($getData['pageInfo']['totalResults']==0){
                            $video_title="※動画が未登録です";
                        }else{
                            $video_title=$getData['items']['0']['snippet']['title'];
                        }
                    }else{
                        $video_title="※一時的な情報制限中です";
                    }
                
            }
        
        @endphp


        @if($loop->iteration % 3 == 1 && $loop->iteration != 1)
    
            </div>
           
            <div class="row text-center mt-3">
        
        @endif
    
            <div class="col-lg-4 mb-5">

                <div class="movie text-left d-inline-block">

                    <div>
                        ＠{!! link_to_route('users.show',$user->name,['id'=>$user->id]) !!}
                        @if($movie)
                            <iframe width="290" height="163.125" src="{{ 'https://www.youtube.com/embed/'.$movie->url }}?controls=1&loop=1&playlist={{ $movie->url }}" frameborder="0"></iframe>
                        @else
                            <iframe width="290" height="163.125" src="https://www.youtube.com/embed/" frameborder="0"></iframe>
                            @php
                                $video_title="※動画が未登録です";
                            @endphp
                        @endif
                    </div>
                    
                    <p>
                        @if(isset($movie->comment))
                            {{ $movie->comment }}
                        @else
                            {{ $video_title }}
                        @endif
                    </p>
                    @auth
                        @if($like_model->like_exist(Auth::user()->id,$movie->id))
                            <p class="favorite-marke">
                                  <span class="js-like-toggle loved"  data-movieid="{{ $movie->id }}"><i class="far fa-heart"></i></span>
                                  <span class="likesCount">{{$movie->likes_count}}</span>
                            </p>
                        @else
                            <p class="favorite-marke">
                                  <span class="js-like-toggle" data-movieid="{{ $movie->id }}"><i class="far fa-heart"></i></span>
                                  <span class="likesCount">{{$movie->likes_count}}</span>
                            </p>
                        @endif​
                    @endauth
                    @guest
                      <span class="likes">
                          <i class="far fa-heart"></i>
                        <span class="like-counter">{{$movie->likes_count}}</span>
                      </span><!-- /.likes -->
                    @endguest

                </div>
                
            </div>

    @endforeach

</div>

{{ $movies->links('pagination::bootstrap-4') }}


@endsection