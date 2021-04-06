@extends('layouts.app')

@section('content')

<a href={{ route('series.index') }}> 作品一覧へ </a>
<div class="text-center">
    <h2>{{ $series->title }}のレビュー</h2>
</div>
<div class="text-center row justify-content-center">
        
    <table class="table table-responsive-sm table-hover">
        <thead class="table-info">
            <tr>
                <th>ユーザー</th>
                <th>コメント</th>
                <th>星</th>
                <th>レビュー編集</th>
                <th>削除</th>
            </tr>
        </thead>
        
        @foreach($reviews as $review)
        <tr>
            <td>{{ $review->userName($review->user_id) }}</td>
            <td>{{ $review->comment }}</td>
            <td>{{ $review->star() }}</td>
            @if( $review->user_id == Auth::id() )
                <td><a href="{{ route('series.series_reviews.edit', ['series' => $review->series_id]) }}">レビュー編集</a></td>
            @else
                <td>    </td>
            @endif
            @if( $review->user_id == Auth::id() )
                <td>
                    <form action="{{ route('series.series_reviews.destroy', ['series' => $review->series_id]) }}" method="POST" onsubmit="if(confirm('本当に削除しますか?')) { return true } else {return false };">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">削除</button>
                    </form>
                </td>
            @else
                <td></td>
            @endif
        </tr>
        @endforeach
    </table>
</div>
@endsection
                   