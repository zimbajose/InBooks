$(document).ready(function () {
    $('.modal').modal();
    var bookid = $('#bookread').attr('data-bookid');
    showSaves();
    $.post('controller.php', {"page": 'readbook', "method": 'getText', "bookid": bookid}, function (data) {
        $('#bookcontainer').html(data);
    });
});



function openData() {
    $('#savesmodal').modal('open');
}

function showSaves() {
    var bookid = $('#bookread').attr('data-bookid');
    var userid = $('#savesmodal').attr('data-userid');
    $.post('controller.php', {"page": 'readbook', "method": 'getSaves', "bookid": bookid, "userid": userid}, function (data) {
        $('#saves').html(data);
    });
}

function makeSave() {
    $('#createsavemodal').modal('open');

}

function deleteSave(id){
    $.post('controller.php', {"page": 'readbook', "method": 'deleteSave',"saveid":id}, function (data) {
        showSaves();
    });
}

function createSave(response) {
    if (response) {
        var bookid = $('#bookread').attr('data-bookid');
        var userid = $('#savesmodal').attr('data-userid');
        var savename = $('#savefilename').val();
        var textid = $('#booktext').attr('data-textid');
        if (savename == '') {
            M.toast({html: "Deve-se colocar um nome para os dados salvos!"});
        } else {
            $.post('controller.php', {"page": 'readbook', "method": 'makeSave', "bookid": bookid, "userid": userid, "savename":savename, "textid":textid}, function (data) {
                showSaves();
                $('#createsavemodal').modal('close');
                $('#savefilename').val('');
               
            });
        }
    } else {
        $('#createsavemodal').modal('close');
    }
}

function save(saveid) {
     var textid = $('#booktext').attr('data-textid');
     $.post('controller.php', {"page": 'readbook', "method": 'save',"saveid":saveid , "textid":textid}, function (data) {
            showSaves();
                
               
            });
}

function load(textid) {
    chooseText(textid);
}

function chooseText(id) {
    var thisid = $('#booktext').attr('data-textid');
    var thistitle = $('#booktext .booktitle').text();
    createhistoric(thisid,thistitle);
    $.post('controller.php', {"page": 'readbook', "method": 'getText', "textid": id}, function (data) {
        $('#bookcontainer').html(data);
    });
    
}

function chooseTextnh(id) {
    $.post('controller.php', {"page": 'readbook', "method": 'getText', "textid": id}, function (data) {
        $('#bookcontainer').html(data);
    });
    
}

function createhistoric(id,title){
    var text = '<div class="historic-entry panel orange accent-1" onclick="chooseTextnh('+id+')"><h5>'+title+'</h5></div>'
    
    $('#historic-content').append(text);
}
