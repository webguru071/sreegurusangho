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

<option value="{{ $countryArea->id }}" @if(($countryArea->id == $selectedId)) selected @endif {{ (count($countryArea->countryAreas()->pluck("id")->toArray() ) == 0) ? null : 'disabled' }}>{{ $depthString }} {{ $countryArea->name_en }} ({{ $countryArea->name_bn }})</option>

<x-council_member.form.countryareas :countryAreas="$countryArea->children" :selectedId="$selectedId"/>
