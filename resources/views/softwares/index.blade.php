<x-layout>

    <h1>Softwares</h1>

    <a href="{{ route('softwares.create') }}">New software</a>

    @foreach ($softwares as $software)
        <h2><a href="{{ route('softwares.show', $software->id) }}">{{ $software->software_name }}</a></h2>
        <p>{{ $software->problem }}</p>
        <p>{{ $software->purpose }}</p>
    @endforeach

    {{ $softwares->links('vendor/pagination/simple-default') }}

</x-layout>
