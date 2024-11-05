<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Book Borrowing</title>
</head>

<body>
<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th scope="col" style="border: 1px solid #dddddd; padding: 8px; text-align: left;">#</th>
            <th scope="col" style="border: 1px solid #dddddd; padding: 8px; text-align: left;">Name</th>
            <th scope="col" style="border: 1px solid #dddddd; padding: 8px; text-align: left;">Book</th>
            <th scope="col" style="border: 1px solid #dddddd; padding: 8px; text-align: left;">Borrowed at</th>
            <th scope="col" style="border: 1px solid #dddddd; padding: 8px; text-align: left;">Returned at</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $key => $book)
            <tr>
                <th scope="row" style="border: 1px solid #dddddd; padding: 8px; text-align: left;">{{ $key + 1 }}</th>
                <td style="border: 1px solid #dddddd; padding: 8px; text-align: left;">{{ $book->user->name }}</td>
                <td style="border: 1px solid #dddddd; padding: 8px; text-align: left;">{{ $book->book->name }}</td>
                <td style="border: 1px solid #dddddd; padding: 8px; text-align: left;">{{ \Carbon\Carbon::parse($book->created_at)->format("d/m/y h:i:s") }}</td>
                <td style="border: 1px solid #dddddd; padding: 8px; text-align: left;">{{ $book->return_date ? \Carbon\Carbon::parse($book->return_date)->format("d/m/y h:i:s") : '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="border: 1px solid #dddddd; padding: 8px; text-align: center;">No data...</td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>

</html>
