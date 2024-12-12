<x-layout>

<h1>{{ $software->name }}</h1>

<p>{{ $software->description }}</p>

<p>{{ $software->size }}</p>

<a href="{{ route('softwares.edit', $software->id) }}">Edit</a>

<form method="post" action="{{ route('softwares.destroy', $software) }}">
    @csrf
    @method('DELETE')

    <button>Delete</button>
</form>

</x-layout>