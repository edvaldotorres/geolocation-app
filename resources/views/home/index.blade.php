@extends('master.master')

@section('title', 'Busca')

@section('content')
    <form action="{{ route('hotel.getNearbyHotels') }}" method="POST">
        @csrf
        <input type="text" name="latitude" placeholder="latitude">
        <input type="text" name="longitude" placeholder="longitude">

        <button type="submit">Buscar</button>
    </form>

    @isset($hotels)
        <ul>
            @foreach ($hotels as $hotel)
                <li>{{ $hotel[0] }}, {{ $hotel['distance'] }} KM, {{ $hotel[3] }}EUR</li>
            @endforeach
        </ul>
    @endisset
@endsection
