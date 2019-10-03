@extends('layouts.app')

@section('content')
<div id="loader"></div>
<div class="container">
    <!-- Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="memberModalLabel">Movie Details</h4>
                </div>
                <div class="dash" style="padding: 20px">
                    <span>Title: </span><span id="title"></span><br>
                    <span>Language: </span><span id="language"></span><br>
                    <span>Overview: </span><span id="overview"></span><br>
                    <span>Popularity: </span><span id="popularity"></span><br>
                    <span>Poster:</span><br><span id="poster"></span><br>
                    <span>Status: </span><span id="status"></span><br>
                    <span>Vote Average: </span><span id="vote-average"></span><br>
                    <span>Vote Count: </span><span id="vote-count"></span><br>
                    <span>Genres: </span><span id="genres"></span><br>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">TMDB Movies List</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
				
                <div id="movies_container">
                    @include('mresult')
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
