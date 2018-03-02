<table>
    <thead>
    <tr>
        @foreach($select as $header)
            <th>{{ $header }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($rs as $item)
        <tr>
            @foreach($item as $field)
                <td>{{ $field }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>