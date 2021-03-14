@extends('layouts.app')

@section('content')

<a href={{ route('series.index') }}> 作品一覧 </a>
<a href={{ route('books.index') }}> 本の一覧 </a>
<div class="text-center">
        
    <table border="1">
        <tr>
            <td>作品名</td>
            <td>コメント</td>
            <td>星</td>
            <td>レビュー編集</td>
            <td>削除</td>
        </tr>
        
        @foreach($reviews as $review)
        <tr>
            
            <td>{{ $review->seriesTitle($review->series_id) }}</td>
            <td>{{ $review->comment }}</td>
            <td>{{ $review->star }}</td>
            <td><a href="{{route('series_reviews.edit', $review->series_id)}}">レビュー編集</a></td>
            <td>
                <form action="{{route('series_reviews.destroy', $review->series_id)}}" method="POST" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                    <!--<input type="hidden" name="series_id" value="{{ $review->series_id }}">-->
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn">削除</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
                   