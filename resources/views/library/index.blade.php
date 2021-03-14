@extends('layouts.app')

@section('content')
<a href={{ route('series.index') }}> 作品一覧 </a>
<a href={{ route('book.index') }}> 本の一覧 </a>
<div class="text-center">
        
    <table border="1">
        <tr>
            <td>作品名</td>
            <td>作者</td>
            <td>所持巻数</td>
            <td>出版社</td>
            <td>最新刊</td>
            <td>刊行状況</td>
            <td>登録日時</td>
            <td>更新日時</td>
        </tr>
        
        @foreach($series as $book)
        <tr>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author }}</td>
            <td></td>
            <td>{{ $book->publisher }}</td>
            <td>{{ $book->current_volume }}</td>
            <td>{{ $book->final_flg }}</td>
            <td>{{ $book->created_at }}</td>
            <td>{{ $book->updated_at }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
                   