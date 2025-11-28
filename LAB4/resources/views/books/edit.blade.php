<h1>Edit Book</h1>

<form action="{{route('books.update', $book->id)}}" method="POST">
    @csrf
    @method('PUT')

    <label>Title:</label>
    <input type="text" name="title" value="{{ old('title', $book->title ?? '') }}" required><br>

    <label>Author:</label>
    <input type="text" name="author" value="{{ old('author', $book->author ?? '') }}" required><br>

    <label>Publish Date:</label>
    <input type="date" name="publish_date" value="{{ old('publish_date', $book->publish_date ?? '') }}" required><br>

    <label>ISBN:</label>
    <input type="text" name="isbn" value="{{ old('isbn', $book->isbn ?? '') }}" required><br>

    <label>Genre:</label>
    <input type="text" name="genre" value="{{ old('genre', $book->genre ?? '') }}" required><br>

    <label>Borrower Name:</label>
    <input type="text" name="borrow_by" value="{{ old('borrow_by', $book->borrow_by ?? '') }}"><br>

    <label>Borrowed At:</label>
    <input type="date" name="borrow_date" value="{{ old('borrow_date', $book->borrow_date ?? '') }}"><br>

    <label>Return At:</label>
    <input type="date" name="return_date" value="{{ old('return_date', $book->return_date ?? '') }}"><br>

    <button type="submit">Update Book</button>
</form>
