<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Borrowed Report</title>
</head>

<body>
  <table style="border-collapse: collapse">
    <thead>
      <tr style="background-color: #f2f2f2">
        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: left">#</th>
        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: left">Name</th>
        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: left">Book</th>
        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: left">Total</th>
        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: left">Borrow At</th>
        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: left">Return Date</th>
        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: left">Return At</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($data as $key => $bor)
        <tr>
          <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: left">{{ $key + 1 }}</th>
          <td style="border: 1px solid #ddd; padding: 8px; text-align: left">{{ $bor->user->name }}</td>
          <td style="border: 1px solid #ddd; padding: 8px; text-align: left">{{ $bor->book->title }}</td>
          <td style="border: 1px solid #ddd; padding: 8px; text-align: left">{{ $bor->total }}</td>
          <td style="border: 1px solid #ddd; padding: 8px; text-align: left">
            {{ \Carbon\Carbon::parse($bor->created_at)->format('d/m/Y h:i:s') }}</td>
          <td style="border: 1px solid #ddd; padding: 8px; text-align: left">
            {{ \Carbon\Carbon::parse($bor->return_date)->format('d/m/Y') }}</td>
          <td style="border: 1px solid #ddd; padding: 8px; text-align: left">
            {{ $bor->return_at != null ? \Carbon\Carbon::parse($bor->return_at)->format('d/m/Y') : '-' }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="6" style="border: 1px solid #ddd; padding: 8px; text-align: center">No data...</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</body>

</html>
