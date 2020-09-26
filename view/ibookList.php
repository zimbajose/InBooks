<?php

class ibookList {

    public static function printBooks($name, $genre) {
        $db = new Conexao();
        if ($name && $genre) {
            $sql = 'SELECT * FROM ibook WHERE name LIKE :name AND genre LIKE :genre';
            $stmt = $db->prepare($sql);
            $genre = '%'.$genre.'%';
            $stmt->bindParam(':genre',$genre );
            $name = '%'.$name.'%';
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Ibook');
            $ibooks = $stmt->fetchAll();
            foreach ($ibooks as $book) {
                if ($book->released == 1) {
                    if ($book->cover_path) {
                        $coverpath = $book->cover_path;
                    } else {
                        $coverpath = "serverimages/noimage.png";
                    }
                    echo '
                    <div class="bookpanel col s12 m12 l6 blue accent-1 panel">
                        <div class="imgcover"><img height="130px" width="130px" class="bookcover left-align" src="' . $coverpath . '"></div>
                         <div class="bookinfo">
                         <h3 class="panel-header bookname center">' . $book->name . '</h3>
                         <h5 class="bookgenre left-align">' . $book->genre . '</h5>
                         <a class="btn waves-light waves-effect teal lighten-2" href="index.php?page=rebook&bookid=' . $book->id . '">Ler</a>    
                         </div>
                    </div>
                ';
                }
            }
        } else if ($name) {
            $sql = 'SELECT * FROM ibook WHERE name LIKE :name';
            $stmt = $db->prepare($sql);
            $name = '%'.$name.'%';
            $stmt->bindParam(':name', $name );
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Ibook');
            $ibooks = $stmt->fetchAll();
            foreach ($ibooks as $book) {
                if ($book->released == 1) {
                    if ($book->cover_path) {
                        $coverpath = $book->cover_path;
                    } else {
                        $coverpath = "serverimages/noimage.png";
                    }
                    echo '
                    <div class="bookpanel col s12 m12 l6 blue accent-1 panel">
                        <div class="imgcover"><img height="130px" width="130px" class="bookcover left-align" src="' . $coverpath . '"></div>
                         <div class="bookinfo">
                         <h3 class="panel-header bookname center">' . $book->name . '</h3>
                         <h5 class="bookgenre left-align">' . $book->genre . '</h5>
                         <a class="btn waves-light waves-effect teal lighten-2" href="index.php?page=rebook&bookid=' . $book->id . '">Ler</a>    
                         </div>
                    </div>
                    ';
                }
            }
        } else if ($genre) {
            $sql = 'SELECT * FROM ibook WHERE genre LIKE :genre';
            $stmt = $db->prepare($sql);
            $genre = '%'.$genre.'%';
            $stmt->bindParam(':genre', $genre);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Ibook');
            $ibooks = $stmt->fetchAll();
            foreach ($ibooks as $book) {
                if ($book->released == 1) {
                    if ($book->cover_path) {
                        $coverpath = $book->cover_path;
                    } else {
                        $coverpath = "serverimages/noimage.png";
                    }
                    echo '
                    <div class="bookpanel col s12 m12 l6 blue accent-1 panel">
                        <div class="imgcover"><img height="130px" width="130px" class="bookcover left-align" src="' . $coverpath . '"></div>
                         <div class="bookinfo">
                         <h3 class="panel-header bookname center">' . $book->name . '</h3>
                         <h5 class="bookgenre left-align">' . $book->genre . '</h5>
                         <a class="btn waves-light waves-effect teal lighten-2" href="index.php?page=rebook&bookid=' . $book->id . '">Ler</a>    
                         </div>
                    </div>
                            ';
                }
            }
        } else {
            $rs = $db->query('SELECT * FROM ibook');
            $rs->setFetchMode(PDO::FETCH_CLASS, 'Ibook');
            $ibooks = $rs->fetchAll();
            foreach ($ibooks as $book) {
                $user = $book->getUser();
                if ($book->released == 1) {
                    if ($book->cover_path) {
                        $coverpath = $book->cover_path;
                    } else {
                        $coverpath = "serverimages/noimage.png";
                    }
                    echo '
                    <div class="bookpanel col s12 m12 l6 blue accent-1 panel">
                        <div class="imgcover"><img height="130px" width="130px" class="bookcover left-align" src="' . $coverpath . '"></div>
                         <div class="bookinfo">
                         <h3 class="panel-header bookname center">' . $book->name . '</h3>
                         <h5 class="bookgenre left-align">' . $book->genre . '</h5>
                         <h6 class="bookauthor">Por: '.$user->username.'</h6>    
                         <a class="btn waves-light waves-effect teal lighten-2" href="index.php?page=rebook&bookid=' . $book->id . '">Ler</a>    
                         </div>
                    </div>
                ';
                }
            }
        }
    }

}
