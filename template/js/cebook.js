//Função de inicialização

$(document).ready(function () {
    $('#returnbutton').hide();
    $('#textcontainer').hide();
    $('#generalconfigmodal').modal();
    $('#confirmingmodal').modal();
    $('#confirmingdelmodal').modal();
    $('#textaddmodal').modal(dismissible = false);
    var ses = function(){save();}
    setInterval(ses,2000);
    var bookid = $('#createbookpage').attr('data-bookid');
    $.post('controller.php', {"page": 'createbook', "bookid": bookid, "method": 'showtexts'}, function (data) {
        $('#textscontainer').html(data);

    });

});


//Funções para terminar o livro


function finishBook() {
    //$('#generalconfigmodal').modal('close');
    $('#confirmingmodal').modal('open');
}
function launch(response) {
    if (response) {
        var bookid = $('#createbookpage').attr('data-bookid');
        $.post('controller.php', {"page": "createbook", "method": "finishbook", "bookid": bookid}, function () {
            window.location.replace('index.php?page=profile');
        });
    } else {
        $('#confirmingmodal').modal('close');
    }
}

//Função para abrir o modal de configurações gerais.
function openGeneral() {

    bookid = $('#createbookpage').attr("data-bookid");
    $.post('controller.php', {"page": "createbook", "method": "openmodal", "bookid": bookid}, function (object) {
        var bookinfo = JSON.parse(object);
        $('#bookname').attr('placeholder', bookinfo.name);
        $('#genre').attr('placeholder', bookinfo.genre);
        $('#generalconfigmodal').modal('open');

    });
}
//Função para fechar o modal de configurações gerais.
function closeGeneral() {
    save();
    $('#generalconfigmodal').modal('close');
}
//Função para selecionar Texto  




function selecttext(textid) {
    bookid = $('#createbookpage').attr("data-bookid");
    $('#textscontainer').hide();
    $('#textscontainer').html('');
    $.post('controller.php', {"page": "createbook", "method": "selecttext", "textid": textid, "bookid": bookid}, function (data) {

        $('#textscontainer').html(data);
        $('#textscontainer').fadeIn();
    });

}
//Funções de deletar
function deletetext(textid) {
    $('#confirmingdelmodal').attr('data-textid', textid);
    $('#confirmingdelmodal').modal('open');
}

function confirmDeletion(response) {
    if (response) {
        var textid = $('#confirmingdelmodal').attr('data-textid');
        $.post('controller.php', {"page": "createbook", "method": "deletetext", "textid": textid}, function (data) {
            selecttext(data);
        });
        $('#confirmingdelmodal').modal('close');
    } else {
        $('#confirmingdelmodal').modal('close');
        $('#confirmingdelmodal').attr('data-textid', '');
    }
}


//Função para salvar no banco de dados
function save() {
    var bookid = $('#createbookpage').attr("data-bookid");
    var textname = $('#textnamebox').val();
    var texttext = $('#texttextarea').val();
    var textid = $('#textedittextid').val();
    var bookname = $('#bookname').val();
    var bookgenre = $('#genre').val();
    $.post('controller.php', {"page": "createbook", "method": "save", "bookname": bookname, "genre": bookgenre, "textname": textname, "bookid": bookid, "textid": textid, "texttext": texttext}, function () {
        
    });
}
//Função para mostrar e editar u texto especifico  um texto especifico
function showtext(textid) {
    $('#textscontainer').hide();
    $('#textcontainer').show();
    $('#returnbutton').show();
    bookid = $('#createbookpage').attr("data-bookid");
    $.post('controller.php', {"page": "createbook", "method": "edittexts", "textid": textid, "bookid": bookid}, function (data) {
        $('#textcontainer').html(data);
        $('#texttextarea').trumbowyg({
            btns: [
                ['undo', 'redo'],
                ['formatting'],
                ['strong', 'em', 'del'],
                ['link'],
                ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                ['unorderedList', 'orderedList'],
                ['horizontalRule'],
                ['removeformat'],
                ['foreColor', 'backColor'],
                ['fontsize']
            ]



        });
        save();
       
        
    });
}
//Função para retornar para o inicio onde cria os livros.
function returntotree() {
    save();
    var textid = $('#textedittextid').val();
    $('#textscontainer').html('');
    $('#textcontainer').html('');
    $('#textcontainer').hide();
    $('#textscontainer').show();
    $('#returnbutton').hide();
    selecttext(textid);
}
//Função para adicionar um novo texto.
function addtext(id) {
    $('#textaddmodal').attr('data-textid', id);
    $('#textaddmodal').modal('open');
    
}

function createtext() {
    var textname = $('#newtextname').val();
    $('#newtextname').val('');
    if (textname == '') {
        M.toast({html:'<i class="material-icons">error</i>O texto deve possuir um nome',classes:'red'})
    } else {
        var id = $('#textaddmodal').attr('data-textid');
        var bookid = $('#createbookpage').attr("data-bookid");
        $.post('controller.php', {"page": "createbook", "textname": textname, "method": "addtext", "fatherid": id, "bookid": bookid}, function (data) {
            
            $('#textaddmodal').modal('close');
            selecttext(id);
        });
    }
}


