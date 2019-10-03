$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#detailsModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var recipient = button.data('movieid'); // Extract info from data-* attributes
    var id = recipient;
    var dataString = 'id=' + recipient;
      $.ajax({
          type: "POST",
          url: "/ajaxRequest",
          data: dataString,
          cache: true,
          success: function (data) {
              var details = JSON.parse(data);
//              console.log(data_);
//              console.log(data_.language);
              $("#detailsModal #title").html(details.title);
              $("#detailsModal #language").html(details.language);
              $("#detailsModal #overview").html(details.overview);
              $("#detailsModal #popularity").html(details.popularity);
              $("#detailsModal #poster").html(details.poster);
              $("#detailsModal #status").html(details.status);
              $("#detailsModal #vote-average").html(details.voteAverage);
              $("#detailsModal #vote-count").html(details.voteCount);
              $("#detailsModal #genres").html(details.genres);
          },
          error: function(err) {
              console.log(err);
          }
      });  
});

$(window).on('hashchange', function() {
    if (window.location.hash) {
        var page = window.location.hash.replace('#', '');
        if (page == Number.NaN || page <= 0) {
            return false;
        }else{
            getData(page);
        }
    }
});
        
var spinner = $('#loader');
$(document).ready(function() {
    // fetchMoviesTMDB ajax request
    var pathname = window.location.pathname;
    if (pathname != '/login') {
        spinner.show();
        $.ajax({
            type: "POST",
            url: "/fetchMoviesTMDB",
            data: '',
            cache: true,
            success: function (data) {
                spinner.hide();
//                console.log(JSON.parse(data));
                $('#movies_container').html(JSON.parse(data));
            },
            error: function(err) {
                console.log(err);
            }
        });  
    }
    // pagination ajax request
    $(document).on('click', '.pagination a',function(event) {
        event.preventDefault();
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');
        var myurl = $(this).attr('href');
        var page = $(this).attr('href').split('page=')[1];
        getData(page);
    });
});

function getData(page){
        $.ajax({
            url: '?page=' + page,
            type: "get",
            datatype: "html"
        })
        .done(function(data)
        {
//            console.log(data);
            $("#movies_container").empty().html(data);
            location.hash = page;
        })
        .fail(function(jqXHR, ajaxOptions, thrownError)
        {
              alert('No response from server');
        });
}