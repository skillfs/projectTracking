<x-layout>

<h1>New Software</h1>

<x-errors />

<form method="post" action="{{ route('softwares.store') }}">
    
<x-softwares.form />

</form>

</x-layout>