<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $bookQuery = Book::query();
        $bookQuery->where('title', 'like', '%'.$request->get('q').'%');
        $bookQuery->orderBy('title');
        $books = $bookQuery->paginate(25);

        return view('books.index', compact('books'));
    }

    public function create()
    {
        $this->authorize('create', new Book);

        return view('books.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', new Book);

        $newBook = $request->validate([
            'title'       => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $newBook['creator_id'] = auth()->id();

        $book = Book::create($newBook);

        return redirect()->route('books.show', $book);
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $this->authorize('update', $book);

        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $this->authorize('update', $book);

        $bookData = $request->validate([
            'title'       => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $book->update($bookData);

        return redirect()->route('books.show', $book);
    }

    public function destroy(Request $request, Book $book)
    {
        $this->authorize('delete', $book);

        $request->validate(['book_id' => 'required']);

        if ($request->get('book_id') == $book->id && $book->delete()) {
            return redirect()->route('books.index');
        }

        return back();
    }
}
