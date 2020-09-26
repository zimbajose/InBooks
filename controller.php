<?php

//Import codes
foreach (glob("model/*.php") as $filename) {
    include_once $filename;
}
foreach (glob('view/*.php') as $filename) {
    include_once $filename;
}
require 'lib/conexao.php';

if (filter_input(INPUT_POST, 'page')) {

    $page = filter_input(INPUT_POST, 'page');
    switch ($page) {
        case 'createbook' :
            createbookpage(filter_input(INPUT_POST, 'method'));
            break;
        case'booklist':
            booklistpage(filter_input(INPUT_POST, 'method'));
            break;
        case 'readbook':
            bookreadpage(filter_input(INPUT_POST, 'method'));
            break;
        case 'profile':
            profilepage(filter_input(INPUT_POST, 'method'));
            break;
    }
}

function profilepage($method) {
    switch ($method) {
        case 'getreleased':
            profile::getreleasedbooks(filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT));
            break;
        case 'getunreleased':
            profile::getunreleasedbooks(filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT));
            break;
        case 'getreading':
            profile::getreadingbooks(filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT));
            break;
        case 'createbook':
            $ibook = new Ibook();
            $ibook->name = "new";
            $ibook->userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT);
            $ibook->genre = '';
            $ibook->released = 0;
            $ibook->coverpath = '';
            $ibook->save();
            break;
        case 'deletebook':
            $bookid = filter_input(INPUT_POST, 'bookid', FILTER_SANITIZE_NUMBER_INT);
            $book = new Ibook($bookid);
            session_start();
            if ($book->user_id != $_SESSION['userid']) {
                echo('https://i.kym-cdn.com/photos/images/facebook/001/014/241/cef.png');
            } else {
                $book->delete();
            }
            break;
        case 'showrd':
            $bookid = filter_input(INPUT_POST, 'bookid', FILTER_SANITIZE_NUMBER_INT);
            $userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT);
            $book = new Ibook($bookid);
            $user = new User($userid);
            profile::showreadingbook($book, $user);
            break;
        case 'showre':
            $bookid = filter_input(INPUT_POST, 'bookid', FILTER_SANITIZE_NUMBER_INT);
            $userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT);
            $book = new Ibook($bookid);
            $user = new User($userid);
            profile::showreleasedbook($book, $user);
            break;
        case 'showunre':
            $bookid = filter_input(INPUT_POST, 'bookid', FILTER_SANITIZE_NUMBER_INT);
            $userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT);
            $book = new Ibook($bookid);
            $user = new User($userid);
            profile::showunreleasedbook($book, $user);
            break;
    }
}

function bookreadpage($method) {
    switch ($method) {
        case'getText':
            $ibook = new Ibook(filter_input(INPUT_POST, 'bookid', FILTER_SANITIZE_NUMBER_INT));
            $textid = filter_input(INPUT_POST, 'textid', FILTER_SANITIZE_NUMBER_INT);
            if ($textid) {
                $text = new Text($textid);
            } else {
                $text = $ibook->getFirstText();
            }
            readBook::showText($text);
            break;
        case'getSaves':
            $ibookid = filter_input(INPUT_POST, 'bookid', FILTER_SANITIZE_NUMBER_INT);
            $userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT);
            $user = new User($userid);
            $book = new Ibook($ibookid);
            readBook::getSaves($user, $book);
            break;
        case 'deleteSave':
            $saveid = filter_input(INPUT_POST, 'saveid', FILTER_SANITIZE_NUMBER_INT);
            $save = new Save($saveid);
            $save->delete();
            break;
        case 'makeSave':
            $ibookid = filter_input(INPUT_POST, 'bookid', FILTER_SANITIZE_NUMBER_INT);
            $userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT);
            $savename = filter_input(INPUT_POST, 'savename', FILTER_SANITIZE_SPECIAL_CHARS);
            $textid = filter_input(INPUT_POST, 'textid', FILTER_SANITIZE_NUMBER_INT);
            $db = new Conexao();
            $sql = "SELECT * FROM usertobook WHERE user_id = :user_id AND ibook_id = :ibook_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':user_id', $userid);
            $stmt->bindParam(':ibook_id', $ibookid);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Usertobook');
            $r = $stmt->fetch();
            $save = new Save();
            $save->name = $savename;
            $save->usertobook_idusertobook = $r->idusertobook;
            $save->text_id = $textid;
            $save->save();
            break;
        case 'save':
            $textid = filter_input(INPUT_POST, 'textid', FILTER_SANITIZE_NUMBER_INT);
            $saveid = filter_input(INPUT_POST, 'saveid', FILTER_SANITIZE_NUMBER_INT);
            $save = new Save($saveid);
            $save->text_id = $textid;
            $save->save();
            break;
    }
}

function booklistpage($method) {
    if ($method) {
        switch ($method) {
            case'listibooks':
                $name = filter_input(INPUT_POST, 'name');
                $genre = filter_input(INPUT_POST, 'genre');
                ibookList::printBooks($name, $genre);
                break;
        }
    }
}

function createbookpage($method) {
    if (isset($method)) {
        switch ($method) {

            case 'finishbook':
                $ibook = new Ibook(filter_input(INPUT_POST, 'bookid', FILTER_SANITIZE_NUMBER_INT));
                $ibook->released = 1;
                session_start();
                if ($_SESSION['userid'] == $ibook->user_id) {
                    $ibook->save();
                }
                header('Location:index.php');
                break;
            case'deletetext':
                $textid = filter_input(INPUT_POST, 'textid', FILTER_SANITIZE_NUMBER_INT);
                $text = new Text($textid);
                $fathertext = $text->getfather();
                $fatherid = $fathertext->id;
                $text->delete();
                echo $fatherid;
                break;
            case'openmodal':
                $bookid = filter_input(INPUT_POST, 'bookid', FILTER_SANITIZE_NUMBER_INT);
                $book = new Ibook($bookid);
                $bookobj = json_encode($book);
                echo $bookobj;
                break;
            case'save':
                $bookname = filter_input(INPUT_POST, 'bookname', FILTER_SANITIZE_SPECIAL_CHARS);
                $genre = filter_input(INPUT_POST, 'genre', FILTER_SANITIZE_SPECIAL_CHARS);
                $bookid = filter_input(INPUT_POST, 'bookid', FILTER_SANITIZE_NUMBER_INT);
                $textname = filter_input(INPUT_POST, 'textname', FILTER_SANITIZE_SPECIAL_CHARS);
                $textid = filter_input(INPUT_POST, 'textid', FILTER_SANITIZE_NUMBER_INT);
                $texttext = filter_input(INPUT_POST, 'texttext');
                $book = new Ibook($bookid);
                $text = new Text($textid);
                session_start();
                if ($book->user_id == $_SESSION['userid'] && ($text->ibook_id == $bookid)) {
                    if ($textname) {
                        $text->name = $textname;
                    }
                    if ($texttext) {
                        $text->text = $texttext;
                    }
                    if ($textid) {
                        $text->save();
                    }
                    $book = new Ibook($bookid);
                    if ($bookname) {
                        $book->name = $bookname;
                    }
                    if ($genre) {
                        $book->genre = $genre;
                    }
                    $book->save();
                }
                break;
            case'edittexts':
                $textid = filter_input(INPUT_POST, 'textid', FILTER_SANITIZE_NUMBER_INT);
                $bookid = filter_input(INPUT_POST, 'bookid', FILTER_SANITIZE_NUMBER_INT);
                $book = new Ibook($bookid);
                session_start();
                if ($textid && $bookid && $book->user_id == $_SESSION['userid']) {
                    createbook::editText($textid, $bookid, FILTER_SANITIZE_NUMBER_INT);
                }
                break;
            case'showtexts':
                $id = filter_input(INPUT_POST, 'bookid', FILTER_SANITIZE_NUMBER_INT);
                $book = new Ibook($id);
                session_start();
                if ($id && $book->user_id == $_SESSION['userid']) {

                    createbook::showTexts($id);
                }
                break;
            case 'showbook':
                break;
            case 'update':

                break;
            case 'selecttext':
                $bookid = filter_input(INPUT_POST, 'bookid', FILTER_SANITIZE_NUMBER_INT);
                $textid = filter_input(INPUT_POST, 'textid', FILTER_SANITIZE_NUMBER_INT);
                $book = new Ibook($bookid);
                session_start();
                if ($textid && $bookid && $book->user_id == $_SESSION['userid']) {
                    createbook::selectText($textid, $bookid);
                }
                break;
            case 'addtext':
                $bookid = filter_input(INPUT_POST, 'bookid', FILTER_SANITIZE_NUMBER_INT);
                $textname = filter_input(INPUT_POST, 'textname', FILTER_SANITIZE_SPECIAL_CHARS);
                $fatherid = filter_input(INPUT_POST, 'fatherid', FILTER_SANITIZE_NUMBER_INT);
                session_start();
                $book = new Ibook($bookid);
                if ($book->user_id == $_SESSION['userid']) {
                    createbook::createText($bookid, $fatherid, $textname);
                }
                break;
        }
    }
}
