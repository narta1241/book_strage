@extends('layouts.app')

@section('content')
<a href={{ route('books.create') }}> 巻数登録 </a>
<a href={{ route('series.index') }}> 作品一覧 </a>
<a href={{ route('series_reviews.index') }}> レビュー一覧 </a>
<div class="text-center">
        
    <table border="1">
        <tr>
            <td>作品名</td>
            <td>巻数</td>
            <td>登録日時</td>
            <td>更新日時</td>
            <td>お気に入り</td>
            <td>編集</td>
            <td>削除</td>
        </tr>
        
        @foreach($books as $book)
        <tr>
            <td>{{ $book->seriesTitle($book->series_id) }}</td>
            <td>{{ $book->volume }}</td>
            <td>{{ $book->created_at }}</td>
            <td>{{ $book->updated_at }}</td>
            <td>
                <form action="{{ route('favorite_books.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="book_id" value={{ $book->id }}>
                    
                    <button type="submit" class="btn {{ $book->favorite_books()->where('user_id', Auth::id())->where('book_id', $book->id)->first() ? "bg-success" : ""}}">お気に入り</button>
                </form>
            </td>
            <td><a href="{{route('books.edit', $book->id)}}">編集</a></td>
            <td>
                <form action="/books/{{ $book->id }}" method="POST" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
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
                   