@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('新規作品') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('series.store') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}" />
                        <div class="form-group">
                            <label for="title" class="col-form-label text-md-right">{{ __('書籍名') }}</label>
                            <input type="text" id="title" name="title" class="form-control">
                            @if ($errors->first('title')) 
                                <p class="validation text-danger">※{{$errors->first('title')}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="author" class="col-form-label text-md-right">{{ __('著者名') }}</label>
                            <input type="text" id="author" name="author" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="publisher" class="col-form-label text-md-right">{{ __('出版社名') }}</label>
                            <input type="text" id="publisher" name="publisher" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="current_volume" class="col-form-label text-md-right">{{ __('最新巻') }}</label>
                            <input type="number" id="current_volume" name="current_volume" class="form-control" min="0">
                            @if ($errors->first('current_volume')) 
                                <p class="validation text-danger">※{{$errors->first('current_volume')}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="final_flg" class="col-form-label text-md-right">{{ __('刊行状況') }}</label>
                            <div>
                                @foreach(App\Series::status_list() as $key => $value)
                                    <div class="form-check form-check-inline">
                                        {{ Form::radio('final_flg', $key, ['id' => 'status'. $key]) }}
                                        <label class=form-check-label for="status{{ $key }}">{{ $value }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('登録') }}
                                </button>
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