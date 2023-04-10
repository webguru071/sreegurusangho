@props(['countryAreas','selectedId'])

@foreach ( $countryAreas as $perCA)
    <x-country_area.form.countryarea :countryArea="$perCA" :selectedId="$selectedId"/>
@endforeach

