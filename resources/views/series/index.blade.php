@extends('layouts.app')

@section('content')
<form action={{ route('bookSearch.search') }} method="POST">
    <div class="input-group row mb-4 ml-4">
        @csrf
        @method('GET')
        <div class="col-md-2">
            <input type="text" name="keyword" class="form-control" placeholder="作品名を入力">
        </div>
        <span class="input-group-btn">
            <button type="submit" class="btn btn-outline-dark">新規作品検索</button>
        </span>
    </div>
</form>

<form action={{ route('series.index') }} method="GET">
    <div class="input-group row  mb-4">
        <!--@method('GET')-->
        @csrf
        <span class="col-md-5"></span>
        <input type="text" name="search" class="col-md-2 form-control" placeholder="作品名を入力"/>
        <span class="input-group-btn ml-2">
            <button type="submit" class='btn btn-outline-dark'>検索</button>
        </span>
        <span class="col-md-4"></span>
         <span class="col-md-1">
            {{ $seriesList->links() }}
        </span>
    </div>
</form>
<div class = "text-center">
    <table class="table table-responsive-sm table-hover">
        <thead class="table-info">
            <tr>
                <th scope="col">作品名</th>
                <th scope="col">画像</th>
                <th scope="col">作者</th>
                <th scope="col">出版社</th>
                <th scope="col">最新巻</th>
                <th scope="col">所持巻</th>
                <th scope="col">巻数編集</th>
                <th scope="col">刊行状況</th>
                <th scope="col">登録日時</th>
                <th scope="col">更新日時</th>
                <th scope="col">編集</th>
                <th scope="col">レビュー一覧</th>
                <th scope="col">レビュー登録/編集</th>
                <th scope="col">お気に入り</th>
                <th scope="col">削除</th>
            </tr>
        </thead>

        @foreach($seriesList as $series)
        <tr>
            <td class = "align-middle">{{ $series->title }}</td>
            <td class = "align-middle"><img src="{{ $series->image }}"></img></td>
            <td class = "align-middle">{{ $series->author }}</td>
            <td class = "align-middle">{{ $series->publisher }}</td>
            <td class = "align-middle">{{ $series->current_volume }}</td>
            <td class = "align-middle">
                @if( $series->checkuser($series->id) )
                    {{ $series->checkuser($series->id)->volume }}
                @else
                    <a class="btn btn-outline-primary" href={{ route('series.user_series.create', ['series' => $series->id]) }}>巻数登録</a>
                @endif
            </td>
            <td class = "align-middle">
                @if( $series->checkuser($series->id) )
                    <a class="btn btn-outline-primary" href={{ route('series.user_series.edit', $series->id) }}>巻数編集</a>
                @endif
            </td>
                <!--<td>-->
                <!--    <form action="" method="post">-->
                <!--        <div class="edit_volume">-->
                <!--            <div class="row justify-content-center">-->
                <!--                <input type="number" id="volume" name="volume" class="col-4" value="{{ $series->user_series()->value('volume') }}">-->
                <!--            </div>-->
                <!--                <button type="submit" id="volume-btn-{{ $series->id}}" data-id="{{ $series->id }}" onclick="volumeStatus({{ $series->id }})">登録</button>-->
                <!--        </div>-->
                <!--    </form>-->
                <!--</td>-->
            <td class = "align-middle">{{ $series->status() }}</td>
            <td class = "align-middle">{{ $series->created_at }}</td>
            <td class = "align-middle">{{ $series->updated_at }}</td>
            <td class = "align-middle">
                @if( $series->user_id == Auth::id() )
                <a class="btn btn-outline-primary" href={{ route('series.edit', $series->id) }}>編集</a>
                @endif
            </td>
            <td class = "align-middle"><a class="btn btn-outline-primary" href={{ route('series.series_reviews.index', ['series' => $series->id]) }}>レビュー一覧</a></td>
            <td class = "align-middle">
                @if( $series->reviewsearch($series->id) )
                    <a class="btn btn-outline-primary" href={{ route('series.series_reviews.edit', ['series' => $series->id]) }}>レビュー編集</a>
                @else
                    <a class="btn btn-outline-primary" href={{ route('series.series_reviews.create', ['series' => $series->id]) }}>レビュー登録</a>
                @endif
            </td>
            <td class = "align-middle">
                <button type="button" id="favorite-btn-{{ $series->id}}" class="btn {{ $series->favorite_series()->where('user_id', Auth::id())->where('series_id', $series->id)->first() ? "bg-success" : "bg-white"}}" data-id="{{ $series->id }}" onclick="favoriteStatus({{ $series->id }})">お気に入り</button>
            </td>
            <td class = "align-middle">
                @if( $series->user_id == Auth::id() )
                <form action="/series/{{ $series->id }}" method="POST" onsubmit="if(confirm('本当に削除しますか?')) { return true } else {return false };">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger">削除</button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
    <div class="float-sm-right">
    {{ $seriesList->links() }}
    </div>
</div>
@endsection

@section('javascript')
    <script>
       function favoriteStatus(id) {
            const seriesId = id;
            $.ajax({
                type: "POST",
                url: "{{ route('favorite_series.store') }}",
                data: {
                    "_token" : "{{ csrf_token() }}",
                    "series_id" : seriesId,
                },
                dataType : "json",
                success: function(data) {

                    if (data.result === 'created') {
                             $('#favorite-btn-' + seriesId).addClass('bg-success');
                        } else {
                             $('#favorite-btn-' + seriesId).removeClass('bg-success');
                        }
                    },
                error: function(err) {
                    alert('error');
                }
            });
                // console.log($(err));
                <!--console.log($(":input"));-->
           // console.log(data.result);
        }
    </script>
    <!--トップ画面で巻数編集できないか模索中-->
    <!--<script>-->
    <!--   function volumeStatus(id,volume) {-->
    <!--        const volumeNew = volume;-->
    <!--        const seriesId = id;-->
    <!--            console.log($(volumeNew));-->
    <!--            console.log($(series_id));-->
    <!--            var url = "{{ route('series.user_series.store', ":series") }}"; -->
    <!--            url = url.replace(':series', seriesId);-->
    <!--        $.ajax({-->
    <!--            type: "POST",-->
    <!--            url:  url,-->
    <!--            data: {-->
    <!--                "_token" : "{{ csrf_token() }}",-->
    <!--                "series_id" : seriesId,-->
    <!--                "user_id" : Auth::id(),-->
    <!--                "volume" : volumeNew,-->
    <!--            },-->
    <!--            dataType : "json",-->
    <!--            success: function(data) {-->
    <!--                alert('成功');-->
    <!--                },-->
    <!--            error: function(err) {-->
    <!--                alert('error');-->
    <!--            }-->
    <!--        });-->
    <!--            //<!--console.log($(":input"));-->
    <!--       // console.log(data.result);-->
    <!--    }-->
    <!--</script>-->
@endsection

