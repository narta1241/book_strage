@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('巻数登録') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('books.store') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}" />
                        <div class="form-group row">
                            <div class="form-group">
                                
                                {{ Form::label('id', '作品名') }}
                                {{ Form::select('id', $plucked_titles, null, ['class' => 'form-control',  'placeholder' => '選択してください']) }}
                            
                            </div>
                            <div class="form-group">
                                <label for="current_volume" class="col-form-label text-md-right">{{ __('最新刊') }}</label>
                                <input type="number" id="volume" name="volume" class="form-control" min="0" max="{{ $book->series->current_volume }}">
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