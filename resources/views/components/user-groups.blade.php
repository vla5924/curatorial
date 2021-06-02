@foreach (Auth::user()->groups as $group)
    @if(isset($selected))
    <option value="{{ $group->id }}" {{ $group->id == $selected ? 'selected' : '' }}>{{ $group->name }}</option>
    @else
    <option value="{{ $group->id }}">{{ $group->name }}</option>
    @endif
@endforeach
