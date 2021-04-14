@extends('layouts.app')

@section('content')
<form action="{{ route('bookSearch.search', ['keyword' => $keyword]) }}" method="POST">
    <div class="input-group row mb-4 ml-4">
        <div class="col-md-2">
            <input type="text" name="keyword" class="form-control" value="{{$keyword}}">
        </div>
        @method('GET')
        @csrf
        <span class="input-group-btn">
            <button type="submit" class="btn btn-outline-dark">新規作品検索</button>
        </span>
    </div>
</form>
<div class = "text-center">
    <table class="table table-responsive-sm table-hover" style="font-size: 15pt;">
        <thead class="table-info">
            <tr>
                <th scope="col">作品名</th>
                <th scope="col">画像</th>
                <th scope="col">作者</th>
                <th scope="col">出版社</th>
                <th scope="col">選択</th>
            </tr>
        </thead>
    <div>
        @foreach ($seriesList as $item)
        <tr>

            <td class ="align-middle">{{ $item['title'] }}</td>
            <td class ="align-middle"><img src="{{ $item['largeImageUrls'] }}"></img></td>
            <td class ="align-middle">{{ $item['author'] }}</td>
            <td class ="align-middle">{{ $item['publisher'] }}</td>
            <td class ="align-middle"><a class="text-dark btn btn-outline-primary" href={{ route('series.create', ['id' => $item['isbn']]) }}>選択</button></a></td>
        </tr>
        @endforeach
    </div>
</div>
@endsection
