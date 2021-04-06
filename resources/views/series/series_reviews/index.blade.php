@extends('layouts.app')

@section('content')

<a href={{ route('series.index') }}> 作品一覧 </a>
<div class="text-center">
    {{ $series->title }}
</div>
<div class="text-center row justify-content-center">

    <table border="1" class="col-auto">
        <tr>
            <td>ユーザー</td>
            <td>コメント</td>
            <td>星</td>
            <td>レビュー編集</td>
            <td>削除</td>
        </tr>

        @foreach($reviews as $review)
        <tr>
            <td>{{ $review->user_name() }}</td>
            <td>{{ $review->comment }}</td>
            <td>{{ $review->star }}</td>
            @if( $review->user_id == Auth::id() )
                <td><a href="{{ route('series.series_reviews.edit', ['series' => $review->series_id, 'series_review' => $review->id]) }}">レビュー編集</a></td>
            @else
                <td>    </td>
            @endif
            @if( $review->user_id == Auth::id() )
                <td>
                    <form action="{{ route('series.series_reviews.destroy', ['series' => $review->series_id, 'series_review' => $review->id]) }}" method="POST" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                        <!--<input type="hidden" name="series_id" value="{{ $review->series_id }}">-->
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn">削除</button>
                    </form>
                </td>
            @else
                <td>    </td>
            @endif
        </tr>
        @endforeach
    </table>
</div>
@endsection
