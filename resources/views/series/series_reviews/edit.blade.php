@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __($book->series->title) }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('series.series_reviews.update', ['series' => $book->series_id]) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}" />
                        <div class="form-group">
                            <div class="form-group">
                                <input type="hidden" name="series_id" value="{{ $book->series_id }}">
                            </div>
                            <div class="form-group">
                                <label for="comment" class="col-form-label text-md-right">{{ __('コメント') }}</label>
                                <textarea id="comment" class="form-control" name="comment" rows="5"><?= $book['comment']; ?></textarea>
                                @if ($errors->first('comment')) 
                                    <p class="validation text-danger">※{{$errors->first('comment')}}</p>
                                @endif
                            </div>
                            <div>
                                {{ Form::label('star', '評価') }}
                                {{ Form::select('star', $book->star_list(), old('star', $book->star), ['class' => 'form-control',  "selected" => old('star', $book->star) ? "selected" : "" ]) }}
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
                    <a href={{ route('series.series_reviews.index', $book->series_id) }}> レビュー一覧へ </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection