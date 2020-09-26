<?php
if (isset($_SESSION['userid'])) {
    header('Location:index.php');
}
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
$password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_SPECIAL_CHARS);
if ($email) {
    if ($email && $username && $password && ($password == $password2)) {
        if (User::checkEmail($email)) {
            $user = new User();
            $user->email = $email;
            $user->username = $username;
            $password = $password.'flyingfish';
            $password = md5($password);
            $user->password = $password;
            $user->save();
            $db = new Conexao();
            $sql = 'SELECT * FROM user WHERE email ="'.$email.'"'; 
            $rs = $db->query($sql);
            $rs->setFetchMode(PDO::FETCH_CLASS, 'User');
            $userid = $rs->fetch()->id;
            $_SESSION['userid'] = $userid;
            header('Location:index.php');
        } else {
            header('Location:index.php?page=registerpage&error=existingemail');
        }
    } else if($password==$password2) {
        header('Location:index.php?page=registerpage&error=wronginfo');
    }
    else{
          header('Location:index.php?page=registerpage&error=passwordnotmatch');
    }
}
?>
<?php
$error = filter_input(INPUT_GET, 'error', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ($error == 'existingemail')
    echo '<script>M.toast({html:"Email já existente"})</script>';
else if ($error == 'wronginfo')
    echo '<script>M.toast({html:"Erro. Por favor cheque suas informações"})</script>';
else if($error =='passwordnotmatch')
    echo '<script>M.toast({html:"Erro. Senhas não combinam"})</script>'
?>
<script src="template/js/registerpage.js"></script>
<div class="container col s8">
    <div class="row">
        <nav>
            <div class="nav-wrapper">
                <div class="col s8">
                    <h3 class="brand-logo col s8">Por favor crie sua conta.</h3>
                </div>
            </div>
        </nav>

    </div>
    <form class="col s14" method="post" action="">

</div>
<div class="row">
    <div class="input-field hoverable col s6">
        <i class="material-icons prefix">account_circle</i>
        <input id="username" name="username" type="text" class="validate">
        <label for="username">Nome de usuário</label>
    </div>
    <div class="input-field hoverable col s6">
        <i class="material-icons prefix">email</i>
        <input id="email" name="email" type="email" class="validate">
        <label for="email">Email</label>
    </div>
</div>
<div class="row">
    <div class="input-field hoverable col s6">
        <i class="material-icons prefix">vpn_key</i>
        <input id="password" name="password" type="password" class="validate">
        <label for="password">Senha</label>
    </div>
    <div class="input-field hoverable col s6">
        <i class="material-icons prefix">replay</i>
        <input id="password2" name="password2" type="password" class="validate">
        <label for="password2">Confirmar Senha</label>
    </div>
</div>
<a class="waves-effect waves-light btn right hoverable"><input type="submit" class="waves-light " style='color:white' value="Criar Conta"><i class="large material-icons right">done</i></a>
</form>

</div>