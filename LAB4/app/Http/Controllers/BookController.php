<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publish_date' => 'required|date',
            'isbn' => 'required|string|max:20|unique:books',
            'genre' => 'required|string|max:100',
            'borrow_by' => 'nullable|string|max:255',
            'borrow_date' => 'nullable|date',
            'return_date' => 'nullable|date|after_or_equal:borrowed_at',
        ]);

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Book added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publish_date' => 'required|date',
            'isbn' => 'required|string|max:20|unique:books,isbn,' . $book->id,
            'genre' => 'required|string|max:100',
            'borrow_by' => 'nullable|string|max:255',
            'borrow_date' => 'nullable|date',
            'return_date' => 'nullable|date|after_or_equal:borrowed_at',
        ]);

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Book updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');

    }
}
