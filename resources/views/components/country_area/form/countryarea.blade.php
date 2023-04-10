@props(['countryArea','selectedId'])

@php
    $depthString = null;
    for ($i = 0; $i < $countryArea->depth; $i++) {
        $depthString = $depthString."---";
    }
@endphp

@if (($depthString == null) && ($countryArea->id > 1))
    <option disabled></option>
@endif

<option value="{{ $countryArea->id }}" @if(($countryArea->id == $selectedId)) selected @endif>{{ $depthString }} {{ $countryArea->name_en }} ({{ $countryArea->name_bn }})</option>

<x-country_area.form.countryareas :countryAreas="$countryArea->children" :selectedId="$selectedId"/>
