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
            <tbody id="tag-container">
                @php $i=1;  @endphp
                @foreach ($movies as $movie)
                <tr>
                    <td>{{ $movie->id }}</td>
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
    <!--{{ $movies->links() }}-->
</div>


{!! $movies->render() !!}