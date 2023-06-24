@extends('layouts.app')

@section('title', __('book.detail'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('book.detail') }}</div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr><td>{{ __('book.title') }}</td><td>{{ $book->title }}</td></tr>
                        <tr><td>{{ __('book.description') }}</td><td>{{ $book->description }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @can('update', $book)
                    <a href="{{ route('books.edit', $book) }}" id="edit-book-{{ $book->id }}" class="btn btn-warning">{{ __('book.edit') }}</a>
                @endcan
                <a href="{{ route('books.index') }}" class="btn btn-link">{{ __('book.back_to_index') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
