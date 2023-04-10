@props(['countryAreas','selectedId'])

@foreach ( $countryAreas as $perCA)
    <x-council_member.form.countryarea :countryArea="$perCA" :selectedId="$selectedId"/>
@endforeach

