@foreach ($prizes ?? [] as $prize)
    @php
        $date = '';
        $date .= ($prize->pivot['date_start']) ? Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $prize->pivot['date_start'])->format('d.m.Y') : '';
        $date .= ($prize->pivot['date_end']) ? ' - '.Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $prize->pivot['date_end'])->format('d.m.Y') : '';
    @endphp

    <p><span class="label {{ ($prize->pivot['confirmed']) ? 'label-primary' : 'label-default' }}">{{ $prize['name'] }}{{ ($date) ? ' ('.$date.')' : '' }}</span></p>
@endforeach
