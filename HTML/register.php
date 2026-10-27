<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/login.css">
    <title>BryanTour</title>
</head>
<body>
    <div class="main">
        <div class="form">
            <p class="title">Bryan<span>Tour</span></p>
            <p class="important-text">Enregistres-toi !</p>
            <div class="form-label">
                <form action="" method="post">
                    <ul>
                        <li>
                            <label for="lastname" class="important-text">Nom</label>
                            <input type="text" id="lastname" name="lastname" required>
                        </li>
                        <li>
                            <label for="firstname" class="important-text">Prénom</label>
                            <input type="text" id="firstname" name="firstname" required>
                        </li>
                        <li>
                            <label for="mail" class="important-text">Email</label>
                            <input type="email" id="mail" name="mail" required>
                        </li>
                        <li>
                            <label for="password" class="important-text">Mot de passe</label>
                            <input type="password" id="pssword" name="pssword" required>
                        </li>
                        <li>
                            <label for="phone" class="important-text">Telephone</label>
                            <input type="tel" id="phone" name="phone" required>
                        </li>
                    </ul>  
                    <div class="connection">
                        <button class="button-connection"
                        type="submit">S'enregistrer</button>
                    </div>             
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>