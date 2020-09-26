<?php ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>


<div class="row" id ="landingpage">
    <div id ="infodiv" class="col s12 m12 l6 left-align">
        <div id="welcome"class="card white">
            <div class="card-content">
                <span class="card-title" id="welcomemessage">Bem vindo ao Inbooks</span>
                <div id="lppps">
                    <p class="lpp">Inbooks é uma plataforma para criação, leitura e publicação de livros interativos, onde o leitor faz escolhas que interferem no rumo da história como visual novels ou alguns jogos.</p>
                    <p class="lpp">No Inbooks qualquer um pode criar e ler qualquer livro interativo sem se preocupar com críticas ou preços.</p>
                    <p class="lpp">Para começar basta criar sua conta clicando no botão abaixo.</p>
                    <a class = "btn green waves-effect waves-light" href="index.php?page=registerpage">Começar</a>
                </div>
            </div>
        </div>

    </div>
    <div class="clear-fix"></div>
    <div id="login" class=" col s12 m12 l6">
        <style>
            @media only screen and (min-width: 995px){
                body{
                    overflow-y:hidden;
                    
                }
            }
        </style>
        
        <div class = "card" id="loginbox">
            <span class="card-title">Já possui uma conta?</span>
            <form method="post" class="card-content" action="index.php?page=loginpage">
                <div class="row">
                    <div class="lpinput col s12 l10 m10">
                        <input placeholder="Ex:Pepe@gmail.com" id="email" type = "text" class="validate"name="email">
                        <label for ="email">Email</label>
                    </div>
                    <div class="lpinput col s12 l10 m10">
                        <input id="passwd" name="password" type="password" class="validate" name="password">
                        <label for = "passwd">Senha</label>
                    </div>
                    <div class="lpinput center col s12 m12 l12">
                        <button type="submit" class="lpinputbtn col s10 btn btn-large waves-effetc indigo">Entrar</button>
                    </div>
                    <div class="lpinput passwdforget col s12 m12 l12">
                        Esqueceu sua senha? clique <a href="index.php?page=passwdforget">aqui</a>.
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="clear-fix"></div>
</div>