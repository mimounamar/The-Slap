<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>The Slap - Inscription</title>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&display=swap" rel="stylesheet" />

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&family=Roboto+Condensed:wght@700&family=Roboto:wght@500&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="../css/draft.css" />
    </head>
    <body>
        <div class="page">
            <div class="credentials_container">
                <a href="../register/" class="credentials_link">Inscription</a>
                <a href="../login/" class="credentials_link">Connexion</a>
            </div>

            <div class="navigation_bar">
                <div class="navigation_logo">
                    <img src="../img/logo.png" />
                </div>

                <div class="navigation_list">
                    <ul>
                        <li class="navigation_component"><a href="../">ACCUEIL</a></li>
                        <li class="navigation_component"><a href="../profiles/">PROFILS</a></li>
                        <li class="navigation_component"><a href="../messages/">MESSAGES</a></li>
                        <li class="navigation_component"><a href="../timeline/">BLOGS</a></li>
                        <li class="navigation_search"><span class="search_label">RECHERCHER</span></li>
                        <form action="../search/" method="get" class="search_form">
                            <input type="text" name="search_input" class="search_field" />
                            <input type="submit" name="search_submit" class="search_submit" value="GO" />
                        </form>
                    </ul>
                </div>
            </div>

            <div class="navigation_adornment">
                <img src="../img/nav_adornment.png" />
            </div>

            <div class="web_outline">
                <div class="web_content">
                    <div class="content_header">
                        <img src="../img/register.png" />
                    </div>
                    <form action="../handlers/?task=registration" method="post">
                        <div class="content">
                <?php
                    if(isset($_GET["message"])){
                        if($_GET["message"]=="verify")
                        {
                            echo "
                            <div class='good_message'>Merci pour votre inscription ! Veuillez vérifier votre adresse mail pour activer votre compte. </div>
                            ";
                        }
                        elseif($_GET["message"]=="verified")
                        {
                           include '../handlers/db.php';
                            $sql = "SELECT * FROM mail_verification WHERE id='".$_GET["id"]."'";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result)!=0)
                            {
                                $data = mysqli_fetch_row($result);
                                $verified_mail = $data[1];
                                $sql = "UPDATE `users` SET `rank`='normal' WHERE `mail`='".$verified_mail."'";
                                $result = mysqli_query($conn, $sql);
                                $sql = "DELETE FROM `mail_verification` WHERE `mail`='".$verified_mail."'";
                                $result = mysqli_query($conn, $sql);
                                echo "
                            <div class='good_message'>Votre compte a été activé ! Vous pouvez désormais vous identifier. </div>
                            ";

                            }
                            elseif(mysqli_num_rows($result)==0)
                            {
                                 echo "
                            <div class='bad_message'>Ce lien a déja été utilisé, ou n'existe pas.</div>
                    ";
                            }
                    }
                }
                    ?>
                            <div class="form_container">
                            	<div class="form_header">
                                    <img src="../img/name.png" />
                                </div>
                                <div class="form_fields">
                                    <label for="username">Nom et prénom</label>
                                    <input type="text" name="name" id="name" required />
                                    <div class="discret_message" id="name_message"></div><br>
                                </div>
                                <div class="form_header">
                                    <img src="../img/username.png" />
                                </div>
                                <div class="form_fields">
                                    <label for="username">Nom d'utilisateur</label>
                                    <input type="text" name="username" id="username" required />
                                    <div class="discret_message" id="username_message"></div><br>
                                </div>
                                <div class="form_header">
                                    <img src="../img/password.png" />
                                </div>
                                <div class="form_fields">
                                    <label for="password">Mot de passe</label>
                                    <input type="password" name="password" id="password" required /><br>
                                    <label for="password">Vérification de mot de passe</label>
                                    <input type="password" name="password_check" id="password_check" required />
                                    <div class="discret_message" id="password_message"></div><br>
                                </div>
                                <div class="form_header">
                                    <img src="../img/mail.png" />
                                </div>
                                <div class="form_fields">
                                    <label for="username">Adresse mail</label>
                                    <input type="mail" name="mail" id="mail" required />
                                     <div class="discret_message" id="mail_message"></div><br>
                                </div>
                                <div class="form_header">
                                    <img src="../img/birthday.png" />
                                </div>
                                <div class="form_fields">
                                    <label for="username">Date de naissance</label>
                                    <input type="date" name="birthday" id="birthday" required />
                                    <div class="discret_message" id="date_message"></div><br>
                                </div>
                                <div class="form_header">
                                    <img src="../img/gender.png" />
                                </div>
                                <div class="form_fields">
                                    <label>Tes pronoms</label>
                                    <input type="radio" name="pronom" id="he" value="he" class="radio" required>
                                    <label for="he">he/him</label><br>
                                    <label> </label>
                                    <input type="radio" name="pronom" id="she" value="she" class="radio" required>
                                    <label for="he">she/her</label><br>
                                    <label> </label>
                                    <input type="radio" name="pronom" id="they" value="them" class="radio" required>
                                    <label for="he">they/them</label><br>
                                </div>
                                 <input type="image" id="submit" name="reg_submit" src="../img/submit.png" alt="Submit" style="margin:10px">
                            </div>
                            <script src="../scripts/register.js"></script>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
