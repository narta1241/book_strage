@extends('layouts.app')

@section('content')
    <div class ="row">
        <div class ="col-sm-8">
            <table class ="text-center table table-responsive-sm table-hover">
                <thead class="table-info">
                <tr>
                    <th scope="col">作品名</th>
                    <th scope="col">画像</th>
                    <th scope="col">作者</th>
                    <th scope="col">出版社</th>
                    <th scope="col">所持巻</th>
                    <th scope="col">巻数編集</th>
                    <th scope="col">刊行状況</th>
                    <th scope="col">次巻発売日</th>
                    <th scope="col">レビュー一覧</th>
                    <th scope="col">レビュー登録/編集</th>
                    <th scope="col">お気に入り</th>
                </tr>
                </thead>
                @foreach($seriesList as $series)
                <tr>
                    <td class = "align-middle">{{ $series->title }}</td>
                    <td class = "align-middle"><img src="{{ $series->image }}"></img></td>
                    <td class = "align-middle">{{ $series->author }}</td>
                    <td class = "align-middle">{{ $series->publisher }}</td>
                    <td class = "align-middle">{{ $series->checkuser($series->id)['volume'] }}</td>
                    <td class = "align-middle"><a class="btn btn-outline-primary" href={{ route('series.user_series.edit', $series->id) }} >巻数編集</a></td>
                    <td class = "align-middle">{{ $series->status() }}</td>
                    <td class = "align-middle">{{ $series->salesDate }}</td>
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
                </tr>
                @endforeach
            </table>
            <div class="float-sm-right">
                {{ $seriesList->links() }}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="container">
                <div class="justify-content-center">
                    <table class="table table-bordered">
                      <tr>
                        <th>所持作品数</th>
                        <td class="text-center">{{ $user->countVolume() }}</td>
                      </tr>
                      <tr>
                        <th>所持巻数合計</th>
                        <td class="text-center">{{ $user->sumVolume() }}</td>
                      </tr>
                      <tr>
                        <th>レビュー数</th>
                        <td class="text-center">{{ $user->reviewCount() }}</td>
                      </tr>
                      <tr>
                        <th>お気に入り書籍数</th>
                        <td class="text-center">{{ $user->favoriteCount() }}</td>
                      </tr>
                    </table>
                    <div class="card">
                        <div class="card-body">
                            <!--CalendarViewの各関数を利用して、タイトルとカレンダー本体をわけて出力-->
                            {!! $dt !!}

                            @if($monthBooks)
                                <div class="">
                                    <!--<th>今月発売の漫画</th>-->
                                    <table class="table" border=1>
                                        <thead class="text-center table-info">
                                            <tr>
                                                <th scope="col">作品名</th>
                                                <th scope="col">画像</th>
                                                <th scope="col">発売日</th>
                                            </tr>
                                        </thead>
                                    @foreach($monthBooks as $day)
                                       
                                        @if($m == $day->conversion($day->salesDate))
                                        <tr>
                                            <td class = "align-middle">{{ $day->title }}</td>
                                            <td class = "img-responsive"><img src={{ $day->image }}></img></td>
                                            <td class = "align-middle">{{ $day->salesDate }}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
               </div>
            </div>
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
