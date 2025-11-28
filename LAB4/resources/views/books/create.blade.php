<h1>Add Book</h1>

<form action="{{route('books.store')}}" method="POST">
    @csrf

    <label>Title:</label>
    <input type="text" name="title" required><br>

    <label>Author:</label>
    <input type="text" name="author" required><br>

    <label>Publish Date:</label>
    <input type="date" name="publish_date" required><br>

    <label>ISBN:</label>
    <input type="text" name="isbn" required><br>

    <label>Genre:</label>
    <input type="text" name="genre" required><br>

    <label>Borrower Name:</label>
    <input type="text" name="borrow_by"><br>

    <label>Borrowed At:</label>
    <input type="date" name="borrow_date"><br>

    <label>Return At:</label>
    <input type="date" name="return_date"><br>

    <button type="submit">Add Book</button>
</form>
