$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});

$('#introduction #seasons a.season').click(function (e) {
    e.preventDefault();

    var seasonId = this.id,
        seasonName = $(this).text(),
        url = this.href;

    $.ajax({
        type: 'GET',
        url: url,
        data: {},
        success: function (data) {
            let competitions = data,
                html = '';

            if (competitions) {
                competitions.forEach(competition => {
                    html += '<a href="competitions/' + competition.id + '" class="btn btn-lg">' + competition.name + '</a>';
                    html += '<a href="seasons/' + seasonId + '/competitions/create" class="crud-button btn-plus btn btn-lg"><div class="plus"></div></a>';
                });
                $('#competitions').html(html);
                $('#current-season').html(seasonName);
            } else {
                $('#competitions').html('error');
            }
        },
        error: function (errorMessage) {
            $('#competitions').html('Error: ' + errorMessage.responseJSON.message);
        }
    });
});
