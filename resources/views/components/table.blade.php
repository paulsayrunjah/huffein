
<table class="table is-striped is-fullwidth">
  <thead>
    <tr>
      <th>CURRENCY</th>
      <th>STATUS</th>
      <th>DATE</th>
      <th>AMOUNT</th>
      <th>ITEMS</th>
    </tr>
  </thead>
  <tbody>

    @foreach ($inwardRecords as $record)
      <tr>
        <td>{{ $record->currency }}</td>
        <td>{{ $record->status }}</td>
        <td>{{ $record->date }}</td>
        <td>{{ toMoney($record->amount) }}</td>
        <td>{{ $record->items }}</td>
      </tr>    
    @endforeach
  </tbody>
</table>