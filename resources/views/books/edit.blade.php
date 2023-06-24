@extends('layouts.app')

@section('title', __('book.edit'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @if (request('action') == 'delete' && $book)
        @can('delete', $book)
            <div class="card">
                <div class="card-header">{{ __('book.delete') }}</div>
                <div class="card-body">
                    <label class="form-label text-primary">{{ __('book.title') }}</label>
                    <p>{{ $book->title }}</p>
                    <label class="form-label text-primary">{{ __('book.description') }}</label>
                    <p>{{ $book->description }}</p>
                    {!! $errors->first('book_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="card-body text-danger">{{ __('book.delete_confirm') }}</div>
                <div class="card-footer">
                    <form method="POST" action="{{ route('books.destroy', $book) }}" accept-charset="UTF-8" onsubmit="return confirm(&quot;{{ __('app.delete_confirm') }}&quot;)" class="del-form float-right" style="display: inline;">
                        {{ csrf_field() }} {{ method_field('delete') }}
                        <input name="book_id" type="hidden" value="{{ $book->id }}">
                        <button type="submit" class="btn btn-danger">{{ __('app.delete_confirm_button') }}</button>
                    </form>
                    <a href="{{ route('books.edit', $book) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
            </div>
        @endcan
        @else
        <div class="card">
            <div class="card-header">{{ __('book.edit') }}</div>
            <form method="POST" action="{{ route('books.update', $book) }}" accept-charset="UTF-8">
                {{ csrf_field() }} {{ method_field('patch') }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="title" class="form-label">{{ __('book.title') }} <span class="form-required">*</span></label>
                        <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title', $book->title) }}" required>
                        {!! $errors->first('title', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">{{ __('book.description') }}</label>
                        <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" rows="4">{{ old('description', $book->description) }}</textarea>
                        {!! $errors->first('description', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{ __('book.update') }}" class="btn btn-success">
                    <a href="{{ route('books.show', $book) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                    @can('delete', $book)
                        <a href="{{ route('books.edit', [$book, 'action' => 'delete']) }}" id="del-book-{{ $book->id }}" class="btn btn-danger float-right">{{ __('app.delete') }}</a>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
