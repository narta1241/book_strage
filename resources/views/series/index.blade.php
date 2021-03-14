@extends('layouts.app')

@section('content')
<a href={{ route('series.create') }}> 作品登録 </a>
<a href={{ route('books.index') }}> 本の一覧 </a>
<a href={{ route('series_reviews.index') }}> レビュー一覧 </a>
<div class="text-center">
        
    <table border="1">
        <tr>
            <td>作品名</td>
            <td>作者</td>
            <td>出版社</td>
            <td>最新刊</td>
            <td>刊行状況</td>
            <td>登録日時</td>
            <td>更新日時</td>
            <td>編集</td>
            <td>レビュー登録</td>
            <td>レビュー編集</td>
            <td>お気に入り</td>
            <td>削除</td>
        </tr>
        
        @foreach($series as $book)
        <tr>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author }}</td>
            <td>{{ $book->publisher }}</td>
            <td>{{ $book->current_volume }}</td>
            <td>{{ $book->status() }}</td>
            <td>{{ $book->created_at }}</td>
            <td>{{ $book->updated_at }}</td>
            <td><a href={{route('series.edit', $book->id)}}>編集</a></td>
            <td><a href={{ route('series_reviews.create', ['series' => $book->id]) }}>レビュー登録</a></td>
            <td><a href={{route('series_reviews.edit', $book->id)}}>レビュー編集</a></td>
            <td>
                <form action="{{ route('favorite_series.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="series_id" value={{ $book->id }}>
                    
                    <button type="submit" class="btn {{ $book->favorite_series()->where('user_id', Auth::id())->where('series_id', $book->id)->first() ? "bg-success" : ""}}">お気に入り</button>
                </form>
            </td>
            <td>
                <form action="/series/{{ $book->id }}" method="POST" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
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
                   