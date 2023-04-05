<div>
    <table>
        <thead>
        <tr>
            <th>Class</th>
            <th>method</th>
            <th>Smell</th>
        </tr>
        </thead>
        @foreach($rows as $row)
        <tr>
            <td>{{ $row['fqcn'] }}</td>
            <td>{{ $row['name'] }}</td>
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
