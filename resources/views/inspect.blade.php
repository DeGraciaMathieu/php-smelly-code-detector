<div>
    <table>
        <thead>
        <tr>
            <th>Class</th>
            <th>method</th>
            <th>visibility</th>
            <th>loc</th>
            <th>arg</th>
            <th>ccl</th>
            <th>Smell</th>
        </tr>
        </thead>
        @foreach($displayableRows as $row)
        <tr>
            <td>{{ $row['fqcn'] }}</td>
            <td>{{ $row['name'] }}</td>
            <td>{{ $row['visibility']->name }}</td>
            <td>{{ $row['loc'] }}</td>
            <td>{{ $row['arg'] }}</td>
            <td>{{ $row['ccl'] }}</td>
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
        <tr>
            <td colspan="7">{{ count($displayableRows) }}/{{ $numberOfRows }} rows displayed</td>
        </tr>
    </table>
</div>
