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