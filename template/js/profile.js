$(document).ready(function () {
    start();
});

function start() {
    $('#releasedbooks').hide();
    $('#booksimreading').hide();
    $('.modal').modal();
    var id = $('#profilepage').attr('data-userid');
    $.post('controller.php', {"page": 'profile', "method": 'getunreleased', "userid": id}, function (data) {
        $('#unbooklist').html(data);

    });
    $.post('controller.php', {"page": 'profile', "method": 'getreleased', "userid": id}, function (data) {
        $('#booklist').html(data);

    });
    $.post('controller.php', {"page": 'profile', "method": 'getreading', "userid": id}, function (data) {
        $('#rebooklist').html(data);

    });

}

function showReadingData(bookid) {
    var userid = $('#profilepage').attr('data-userid');
    $.post('controller.php', {"page": 'profile', "method": 'showrd', "userid": userid, "bookid": bookid}, function (data) {
        $('#myinfobox').hide();
        $('#myinfobox').fadeIn();
        $('#myinfobox').html(data);
    });
}

function showUnReData(bookid) {
    var userid = $('#profilepage').attr('data-userid');
    $.post('controller.php', {"page": 'profile', "method": 'showunre', "userid": userid, "bookid": bookid}, function (data) {
        $('#bookpanelbox').hide();
        $('#bookpanelbox').fadeIn();
        $('#bookpanelbox').html(data);
    });
}

function showReData(bookid) {
    var userid = $('#profilepage').attr('data-userid');
    $.post('controller.php', {"page": 'profile', "method": 'showre', "userid": userid, "bookid": bookid}, function (data) {
        $('#bookinfobox').hide();
        $('#bookinfobox').fadeIn();
        $('#bookinfobox').html(data);
    });
}

function select(target) {
    if (target == 0) {
        $('.userbooklist').hide();
        $('#releasedbooks').fadeIn();
        $('.pagelink').removeClass('active');
        $('#pagelink0').addClass('active');
    } else if (target == 1) {
        $('.userbooklist').hide();
        $('#unreleasedbooks').fadeIn();
        $('.pagelink').removeClass('active');
        $('#pagelink1').addClass('active');
    } else {
        $('.userbooklist').hide();
        $('#booksimreading').fadeIn();
        $('.pagelink').removeClass('active');
        $('#pagelink2').addClass('active');
    }
}

function search() {

}

function deletebook(id) {
    $('#confirmbookdelete').attr('data-id', id);
    $('#confirmbookdelete').modal('open');
}

function confirmDeletion() {
    var bookid = $('#confirmbookdelete').attr('data-id');
    $.post('controller.php', {"page": 'profile', "method": 'deletebook', "bookid": bookid}, function (data) {
        if(data){
            $('body').html(data);
        }
    });
    refresh();
    $('#confirmbookdelete').modal('close');
}
function refresh(){
    var id = $('#profilepage').attr('data-userid');
    $.post('controller.php', {"page": 'profile', "method": 'getunreleased', "userid": id}, function (data) {
        $('#unbooklist').html(data);

    });
    $.post('controller.php', {"page": 'profile', "method": 'getreleased', "userid": id}, function (data) {
        $('#booklist').html(data);

    });
}

function addBook() {
    var id = $('#profilepage').attr('data-userid')
    $.post('controller.php', {"page": 'profile', "method": 'createbook', "userid": id}, function (data) {
        location.reload();
    });

}