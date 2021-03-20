@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('巻数登録') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('series.user_series.store', ['series' => $series->id]) }}">
                        @csrf
                        <div class="form-group row">
                            <div class="form-group">
                                <label for="current_volume" class="col-form-label text-md-right">{{ __('所持巻') }}</label>
                                <input type="number" id="volume" name="volume" class="form-control" min=1>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection