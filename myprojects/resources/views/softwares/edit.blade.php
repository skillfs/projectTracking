<x-layout>

<h1>Edit Software</h1>

<x-errors />

<form method="post" action="{{ route('softwares.update', $software) }}">
    @method('PATCH')

    
    <x-softwares.form :software="$software" />

</form>

</x-layout>