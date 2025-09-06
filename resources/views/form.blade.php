<!DOCTYPE html>
<html>
<head>
    <title>One-Time Form</title>
</head>
<body>
    <h1>Fill the Form (Only Once)</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('form.submit') }}" method="POST">
        @csrf
        <label>Name:</label>
        <input type="text" name="name" required> <br><br>

        <label>Email:</label>
        <input type="email" name="email" required> <br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
