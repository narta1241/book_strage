@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __($series->title) }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('series.user_series.update', $series->id)}}">
                        @csrf
                        @method('PUT')
                       <div class="form-group row">
                            <div class="form-group">
                                <label for="volume" class="col-form-label text-md-right">{{ __('巻数') }}</label>
                                <input type="number" id="volume" name="volume" class="form-control" min=1 value={{ $volume }}>
                                @if ($errors->first('volume')) 
                                    <p class="validation text-danger">※{{$errors->first('volume')}}</p>
                                @endif
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
                    <div class = "text-right">
                        <form action="{{ route('series.user_series.destroy', $series->id)}}" method="POST" onsubmit="if(confirm('本当に削除しますか?')) { return true } else {return false };">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection