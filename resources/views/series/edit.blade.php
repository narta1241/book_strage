@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('作品') }}</div>
                    <div class="card-body">
                        <form method="POST" action="/series/{{ $series->id }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="form-group col-md-6">
                            <label for="title" class="col-form-label text-md-right">{{ __('作品名') }}</label>
                            <input type="text" id="title" name="title" class="form-control" value={{ $series->title }}>
                            @if ($errors->first('title')) 
                                <p class="validation text-danger">※{{$errors->first('title')}}</p>
                            @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="image" class="col-form-label text-md-right">{{ __('画像:') }}</label>
                                <img src="{{ $series->image }}"></img>
                                <input type="hidden" id="image" name="image" class="form-control" value="{{ $series->image }}">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="author" class="col-form-label text-md-right">{{ __('著者名') }}</label>
                                <input type="text" id="author" name="author" class="form-control" value={{ $series->author }}>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="publisher" class="col-form-label text-md-right">{{ __('出版社名') }}</label>
                                <input type="text" id="publisher" name="publisher" class="form-control" value={{ $series->publisher }}>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="current_volume" class="col-form-label text-md-right">{{ __('最新巻') }}</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="number" id="current_volume" name="current_volume" class="form-control" value={{ $series->current_volume }}>
                                        @if ($errors->first('current_volume')) 
                                            <p class="validation text-danger">※{{$errors->first('current_volume')}}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="final_flg" class="col-form-label text-md-right">{{ __('刊行状況') }}</label>
                                <div>
                                    @foreach(App\Series::status_list() as $key => $value)
                                        <div class="form-check form-check-inline">
                                            {{ Form::radio('final_flg', $key, ($series->final_flg == $key ? true : false), ['id' => 'status'. $key]) }}
                                            <label class=form-check-label for="status{{ $key }}">{{ $value }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('登録') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <a href={{ route('series.index') }}> 戻る </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection