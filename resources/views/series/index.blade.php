@extends('layouts.app')

@section('content')
<a href={{ route('series.create') }}> 作品登録 </a>
@if( $user )
    <div class = "text-right">所持巻数合計：{{ $user->sumVolume() }}</div>
@else
    <td>    </td>
@endif
<div class = "text-center">
    
    <table class="table table-dark">
        <tr>
            <td>作品名</td>
            <td>作者</td>
            <td>出版社</td>
            <td>最新巻</td>
            <td>所持巻</td>
            <td>巻数編集</td>
            <td>刊行状況</td>
            <td>登録日時</td>
            <td>更新日時</td>
            <td>編集</td>
            <td>レビュー一覧</td>
            <td>レビュー登録/編集</td>
            <td>お気に入り</td>
            <td>削除</td>
        </tr>
        
        @foreach($serieslist as $series)
        <tr>
            <td>{{ $series->title }}</td>
            <td>{{ $series->author }}</td>
            <td>{{ $series->publisher }}</td>
            <td>{{ $series->current_volume }}</td>
            @if( $series->checkuser($series->id) )
                <td>{{ $series->checkuser($series->id)->volume }}</td>
            @else
                <td><a href={{ route('series.user_series.create', ['series' => $series->id]) }}>巻数登録</a></td>
            @endif
            @if( $series->checkuser($series->id) )
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
                <td><a href={{ route('series.user_series.edit', $series->id) }}>巻数編集</a></td>
            @else
                <td>    </td>
            @endif
            <td>{{ $series->status() }}</td>
            <td>{{ $series->created_at }}</td>
            <td>{{ $series->updated_at }}</td> 
            @if( $series->user_id == Auth::id() )
                <td><a href={{ route('series.edit', $series->id) }}>編集</a></td>
            @else
                <td>    </td>
            @endif
            <td><a href={{ route('series.series_reviews.index', ['series' => $series->id]) }}>レビュー一覧</a></td>
            @if( $series->reviewsearch($series->id) )
                <td><a href={{ route('series.series_reviews.edit', ['series' => $series->id]) }}>レビュー編集</a></td>
            @else
                <td><a href={{ route('series.series_reviews.create', ['series' => $series->id]) }}>レビュー登録</a></td>
            @endif
            
            <td>
                <button type="button" id="favorite-btn-{{ $series->id}}" class="btn {{ $series->favorite_series()->where('user_id', Auth::id())->where('series_id', $series->id)->first() ? "bg-success" : "bg-white"}}" data-id="{{ $series->id }}" onclick="favoriteStatus({{ $series->id }})">お気に入り</button>
            </td>
            <!--トップ画面で巻数編集できないか模索中-->
            <!--<td>-->
            <!--    <form action="{{ route('favorite_series.store') }}" method="POST">-->
            <!--        @csrf-->
            <!--        <input type="hidden" name="series_id" value={{ $series->id }}>-->
                    
            <!--        <button type="submit" class="btn {{ $series->favorite_series()->where('user_id', Auth::id())->where('series_id', $series->id)->first() ? "bg-success" : ""}}">お気に入り</button>-->
            <!--    </form>-->
            <!--</td>-->
            <td>
                @if( $series->user_id == Auth::id() )
                <form action="/series/{{ $series->id }}" action="{{ route('series.series_reviews.destroy', ['series' => $series->id]) }}" action="{{ route('series.user_series.destroy', $series->id)}}" method="POST" onsubmit="if(confirm('本当に削除しますか?')) { return true } else {return false };">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger">削除</button>
                </form>
                @else
                    <td>    </td>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
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

