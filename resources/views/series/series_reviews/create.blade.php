@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __($title.' レビュー登録') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('series.series_reviews.store', ['series' => $id]) }}">
                        @csrf
                        <div class="form-group row">
                            <div class="form-group">
                                <label for="comment" class="col-form-label text-md-right">{{ __('コメント') }}</label>
                                <textarea id="comment" class="form-control" name="comment"></textarea>
                                @if ($errors->first('comment')) 
                                    <p class="validation text-danger">※{{$errors->first('comment')}}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="star" class="col-form-label text-md-right">評価(５点満点)</label>
                                <input type="number" name="star" id="star" class="form-control" min="1" max="5">
                                @if ($errors->first('star')) 
                                    <p class="validation text-danger">※{{$errors->first('star')}}</p>
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
                    <a href={{ route('series.series_reviews.index', $id) }}> レビュー一覧へ </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection