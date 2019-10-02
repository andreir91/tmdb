@extends('layouts.app')

@section('content')
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
                    <span>Title: </span><span id="title"></span><br><br>
                    <span>Language: </span><span id="language"></span><br><br>
                    <span>Overview: </span><span id="overview"></span><br><br>
                    <span>Popularity: </span><span id="popularity"></span><br><br>
                    <span>Poster:</span><br><span id="poster"></span><br><br>
                    <span>Status: </span><span id="status"></span><br><br>
                    <span>Vote Average: </span><span id="vote-average"></span><br><br>
                    <span>Vote Count: </span><span id="vote-count"></span><br>
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
				
                    <div class="panel-body">				
                            <table class="table">
                                    <thead>
                                      <tr>
                                            <th>Id</th>
                                            <th>Title</th>
                                            <th>Genre(s)</th>
                                            <th>Release Data</th>
                                            <th>Details</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @php $i=1;  @endphp
                                        @foreach ($movies as $movie)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $movie->originalTitle }}</td>
                                            <td>{{ $movie->genres }}</td>
                                            <td>{{ date('d-m-Y', strtotime($movie->releaseData)) }}</td>
                                            <td><a class="btn btn-small btn-primary"
                                                    data-toggle="modal"
                                                    data-target="#detailsModal"
                                                    id="getUser"
                                                    data-movieId="{{$movie->movieID}}">Details</a>
                                            </td>
                                        </tr>
                                        @php $i++;  @endphp
                                        @endforeach

                                    </tbody>
                            </table>
                            {{ $movies->links() }}
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
