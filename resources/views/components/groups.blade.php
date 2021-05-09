@foreach ($groups as $group)
    <a href="{{ route('practicesByGroup', $group->alias) }}">
        <b>{{ $group->name }}</b>
    </a> &middot;
@endforeach
