$(document).ready(function () {
    getbooks();
});

function getbooks() {
    $.post('controller.php', {"page": 'booklist', "method": 'listibooks', "name": '', "genre": ''}, function (data) {
        $('#booksdiv').html(data);

    });
    
}

function searchbooks(){
    var bookname= $('#chbookname').val();
    var bookgenre = $('#chbookgenre').val();
    $.post('controller.php', {"page": 'booklist', "method": 'listibooks', "name":bookname, "genre":bookgenre}, function (data) {
        $('#booksdiv').html(data);

    });
}

function clean(){
    getbooks();
    $('#chbookgenre').val('');
    $('#chbookname').val('');
}

