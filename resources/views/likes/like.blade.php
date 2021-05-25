@if($like_model->like_exist(Auth::user()->id,$post->id))
    <p class="favorite-marke">
      <a class="js-like-toggle loved" href="" data-postid="{{ $post->id }}"><i class="fas fa-heart"></i></a>
      <span class="likesCount">{{$post->likes_count}}</span>
    </p>
@else
    <p class="favorite-marke">
      <a class="js-like-toggle" href="" data-postid="{{ $post->id }}"><i class="fas fa-heart"></i></a>
      <span class="likesCount">{{$post->likes_count}}</span>
    </p>
@endif​