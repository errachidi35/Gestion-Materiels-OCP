@props(['material'])

<x-card>
    <div class="flex">
        <img
            class="hidden w-48 mr-6 md:block"
            src="{{$material->image ? asset('storage/' . $material->image) : asset('/images/logo.png')}}"
            alt=""
        />
        <div>
            <h3 class="text-2xl">
                <a href="/materials/{{$material->id}}">{{$material->name}}</a>
            </h3>
            <div class="text-xl font-bold mb-4">{{$material->code}}</div>
            {{-- <x-material-tags :tagsCsv="$material->tags" /> --}}
            <div class="text-lg mt-4">
                <i class="fa-solid fa-location-dot"></i> {{$material->location}}
            </div>
        </div>
    </div>
</x-card>
