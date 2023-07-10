<div>
  @if($displayableRows)
  <div>
    <table>
      <thead>
          <tr>
          <th>file</th>
          <th>method</th>
          <th>visibility</th>
          <th>loc</th>
          <th>arg</th>
          <th>ccn</th>
          <th>Smell</th>
        </tr>
      </thead>
      @foreach($displayableRows as $row)
      <tr>
        <td>{{ $row['class'] }}</td>
        <td>{{ $row['method'] }}</td>
        <td>{{ $row['visibility'] }}</td>
        <td>{{ $row['loc'] }}</td>
        <td>{{ $row['arg'] }}</td>
        <td>{{ $row['ccn'] }}</td>
      <td>
      @if($row['smell'] > 1000)
        <b class="text-red-700">{{ $row['smell'] }}</b>
      @elseif($row['smell'] > 500)
        <b class="text-orange">{{ $row['smell'] }}</b>
      @else
        <b class="text-green">{{ $row['smell'] }}</b>
      @endif
        </td>
      </tr>
      @endforeach
    </table>
  </div>
  <div>{{ count($displayableRows) }}/{{ $numberOfRows }} methods displayed</div>
  @else
  No methods found.
  @endif
</div>
