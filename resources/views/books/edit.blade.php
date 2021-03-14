@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __($book->series->title) }}</div>

                <div class="card-body">
                    <form method="POST" action="/books/{{ $book->id }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}" />
                        <input type="hidden" name="series_id" value="{{ $book->series->id }}">
                        <div class="form-group row">
                            <div class="form-group">
                                <label for="volume" class="col-form-label text-md-right">{{ __('巻数') }}</label>
                                <input type="number" id="volume" name="volume" min="0" max="{{ $book->series->current_volume }} "class="form-control" value={{ $book->volume }}>
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
                    <a href="{{ URL::previous() }}">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection