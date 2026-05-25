@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="/" class="btn btn-outline-secondary">
            ⬅️ {{ trans('messages.back_to_home') ?? 'Back to List' }}
        </a>
    </div>

    @if(isset($movie['Response']) && $movie['Response'] == 'False')
        <div class="alert alert-danger">
            <h5>Error!</h5>
            <p>{{ $movie['Error'] ?? 'Movie data not found.' }}</p>
        </div>
    @else
        <div class="card shadow-sm border-0 bg-white p-4">
            <div class="row">
                <div class="col-md-4 text-center mb-4 mb-md-0">
                    @php
                        $poster = (isset($movie['Poster']) && $movie['Poster'] !== 'N/A') ? $movie['Poster'] : 'https://via.placeholder.com/350x500?text=No+Image';
                    @endphp
                    <img src="{{ $poster }}" class="img-fluid rounded shadow" alt="{{ $movie['Title'] ?? 'No Title' }}" style="max-height: 500px; object-fit: cover;">
                </div>

                <div class="col-md-8">
                    <div class="d-flex align-items-center flex-wrap mb-2">
                        <h2 class="font-weight-bold text-dark mb-0 mr-3">{{ $movie['Title'] ?? '-' }}</h2>
                        <span class="badge badge-warning font-weight-bold px-3 py-2">⭐️ {{ $movie['imdbRating'] ?? 'N/A' }}/10</span>
                    </div>
                    
                    <p class="text-muted mb-4">
                        <span class="mr-2">📅 {{ $movie['Year'] ?? '-' }}</span> | 
                        <span class="mx-2">⏱️ {{ $movie['Runtime'] ?? '-' }}</span> | 
                        <span class="ml-2">🎭 {{ $movie['Genre'] ?? '-' }}</span>
                    </p>

                    <hr>

                    <h5 class="font-weight-bold text-secondary">{{ trans('messages.plot') ?? 'Plot / Synopsis' }}</h5>
                    <p class="text-justify lead" style="font-size: 1.05rem; line-height: 1.6;">
                        {{ $movie['Plot'] ?? '-' }}
                    </p>

                    <hr>

                    <div class="row mt-3">
                        <div class="col-sm-3 font-weight-bold text-muted">{{ trans('messages.director') ?? 'Director' }}</div>
                        <div class="col-sm-9 text-dark">: {{ $movie['Director'] ?? '-' }}</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-3 font-weight-bold text-muted">{{ trans('messages.writer') ?? 'Writer' }}</div>
                        <div class="col-sm-9 text-dark">: {{ $movie['Writer'] ?? '-' }}</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-3 font-weight-bold text-muted">{{ trans('messages.actors') ?? 'Actors' }}</div>
                        <div class="col-sm-9 text-dark">: {{ $movie['Actors'] ?? '-' }}</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-3 font-weight-bold text-muted">Language</div>
                        <div class="col-sm-9 text-dark">: {{ $movie['Language'] ?? '-' }}</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-3 font-weight-bold text-muted">Awards</div>
                        <div class="col-sm-9 text-dark">: {{ $movie['Awards'] ?? '-' }}</div>
                    </div>

                    <div class="mt-4 pt-2">
                        <button onclick="addToFavorite('{{ $movie['imdbID'] }}', '{{ addslashes($movie['Title']) }}', '{{ $movie['Year'] }}', '{{ $movie['Poster'] }}')" class="btn btn-sm btn-warning font-weight-bold">
                            ⭐ Favorite
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>

@endsection