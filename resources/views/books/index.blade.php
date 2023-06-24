@extends('layouts.app')

@section('title', __('book.list'))

@section('content')
<div class="mb-3">
    <div class="float-right">
        @can('create', new App\Models\Book)
            <a href="{{ route('books.create') }}" class="btn btn-success">{{ __('book.create') }}</a>
        @endcan
    </div>
    <h1 class="page-title">{{ __('book.list') }} <small>{{ __('app.total') }} : {{ $books->total() }} {{ __('book.book') }}</small></h1>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                    <div class="form-group">
                        <label for="q" class="form-label">{{ __('book.search') }}</label>
                        <input placeholder="{{ __('book.search_text') }}" name="q" type="text" id="q" class="form-control mx-sm-2" value="{{ request('q') }}">
                    </div>
                    <input type="submit" value="{{ __('book.search') }}" class="btn btn-secondary">
                    <a href="{{ route('books.index') }}" class="btn btn-link">{{ __('app.reset') }}</a>
                </form>
            </div>
            <table class="table table-sm table-responsive-sm table-hover">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>{{ __('book.title') }}</th>
                        <th>{{ __('book.description') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $key => $book)
                    <tr>
                        <td class="text-center">{{ $books->firstItem() + $key }}</td>
                        <td>{!! $book->title_link !!}</td>
                        <td>{{ $book->description }}</td>
                        <td class="text-center">
                            @can('view', $book)
                                <a href="{{ route('books.show', $book) }}" id="show-book-{{ $book->id }}">{{ __('app.show') }}</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">{{ $books->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
</div>
@endsection
