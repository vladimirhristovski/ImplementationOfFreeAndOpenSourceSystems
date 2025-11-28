<h1>Books</h1>
<a href="{{ route('books.create') }}">Add New Book</a>

@if(session('success'))
    <div>{{ session('success') }}</div>
@endif

<table border="1">
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Publish Date</th>
        <th>ISBN</th>
        <th>Genre</th>
        <th>Borrower</th>
        <th>Borrow Date</th>
        <th>Return Date</th>
        <th>Actions</th>
    </tr>
    @foreach($books as $book)
        <tr>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author }}</td>
            <td>{{ $book->publish_date }}</td>
            <td>{{ $book->isbn }}</td>
            <td>{{ $book->genre }}</td>
            <td>{{ $book->borrow_by }}</td>
            <td>{{ $book->borrow_date }}</td>
            <td>{{ $book->return_date }}</td>
            <td>
                <a href="{{ route('books.edit', $book) }}">Edit</a>
                <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button>Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
