@inject('helper', App\Modules\Render\Helper::class)
<div>
    @if($displayableRows)
    <div>
        <table>
            <thead>
                <tr>
                    <th>class</th>
                    <th>count</th>
                    <th>smell</th>
                    <th>avg</th>
                    <th>public</th>
                    <th>prot.</th>
                    <th>priv.</th>
                </tr>
            </thead>
            @foreach($displayableRows as $class => $metrics)
            <tr>
                <td>{{ $class }}</td>
                <td>{{ $metrics['count'] }}</td>
                <td>
                    @if($metrics['smell'] > 1000)
                    <b class="text-red-700">{{ $metrics['smell'] }}</b>
                    @elseif($metrics['smell'] > 500)
                    <b class="text-orange">{{ $metrics['smell'] }}</b>
                    @else
                    <b class="text-green">{{ $metrics['smell'] }}</b>
                    @endif
                </td>
                <td>
                    @if($metrics['avg'] > 1000)
                    <b class="text-red-700">{{ (int) $metrics['avg'] }}</b>
                    @elseif($metrics['avg'] > 500)
                    <b class="text-orange">{{ (int) $metrics['avg'] }}</b>
                    @else
                    <b class="text-green">{{ (int) $metrics['avg'] }}</b>
                    @endif
                </td>
                <td>{{ $helper::numberFormat($metrics['public']) }} %</td>
                <td>{{ $helper::numberFormat($metrics['protected']) }} %</td>
                <td>{{ $helper::numberFormat($metrics['private']) }} %</td>
            </tr>
            @endforeach
        </table>
    </div>
    <div>{{ count($displayableRows) }}/{{ $numberOfRows }} class displayed</div>
    @else
    No methods found.
    @endif
</div>