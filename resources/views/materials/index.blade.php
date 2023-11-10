@extends('layout')

@section('content')
@include('partials\_hero')
@include('partials\_search')



<div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">

@unless(count($materials)==0)

@foreach($materials as $material)
    <x-material-card :material="$material" />
@endforeach

@else 
<p>No materials found</p>
@endunless

</div>

<div class="mt-6 p-4">
    {{$materials->links()}}
</div>
@endsection

