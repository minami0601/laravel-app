$(function () {
    let likeClick = $('.no-login');
    likeClick.on('click', function(){
        alert('ログインしてください')
    })
    let like = $('.js-like-toggle');
    let likeMovieId;
    
    like.on('click', function () {
        let $this = $(this);
        likeMovieId = $this.data('movieid');
        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/ajaxlike',  //routeの記述
                type: 'POST',
                data: {
                    'movie_id': likeMovieId //コントローラーに渡すパラメーター
                },
        })
    
            // Ajaxリクエストが成功した場合
            .done(function (data) {
    //lovedクラスを追加
                $this.toggleClass('loved'); 
    
    //.likesCountの次の要素のhtmlを「data.postLikesCount」の値に書き換える
                $this.next('.likesCount').html(data.movieLikesCount); 
    
            })
            // Ajaxリクエストが失敗した場合
            .fail(function (data, xhr, err) {
    //ここの処理はエラーが出た時にエラー内容をわかるようにしておく。
    //とりあえず下記のように記述しておけばエラー内容が詳しくわかります。笑
                console.log(data);
                console.log('エラー');
                console.log(err);
                console.log(xhr);
            });
        
        return false;
    });
});