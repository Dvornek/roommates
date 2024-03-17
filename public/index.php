<!DOCTYPE html>
<html lang="sr">

<head>
    <base href="/roommates/public/html/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow,noimageindex,nosnippet,noarchive,notranslate">
    <meta name="author" content="Tri i po musketara">
    <meta name="description" content="Roommates">
    <meta name="keywords" content="Roommates">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <link rel="icon" type="image/x-icon" href="../img/Roommates.png">
    <link type="text/css" rel="stylesheet" media="screen" href="../css/styleScreen.css">
    <link type="text/css" rel="stylesheet" media="print" href="../css/stylePrint.css">
    <title>Roommates</title>
</head>

<body>
    <header>
        <nav>
            <a href="../../home" id="logo" class="navElements"><img src="../img/Roommates.png" alt="Roommates"
                    width="32px"></a>
            <a href="../../home" class="navElements" id="logoText">Roommates</a>
            <form id="search" class="navElements">
                <span id="searchBar" class="navElements">
                    <label for="searchButton"><img src="../img/geo-alt-fill.svg" alt="Location icon"></label>
                    <input type="text" placeholder="Pretraga po gradu" id="citySearchInput">
                    <label for="searchButton"><img src="../img/search.svg" alt="Search icon"></label>
                    <input type="submit" id="searchButton" style="display:none;">
                </span>
            </form>
            <span>
                <ul class="menu">
                    <li class="dropdown">
                        <img src="../img/list.svg" alt="menu" width="32px">
                        <ul class="submenu">
                            <li>
                                <a href="../../login" id="loginLink">Ulogujte se</a>
                            </li>
                            <li>
                                <a href="../../registration" id="registerLink">Registrujte se</a>
                            </li>
                            <li>
                                <a href="../../my-profile" id="my-account">Moj nalog</a>
                            </li>
                            <li>
                                <a><span id="logout-span">Izlogujte se</span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </span>
        </nav>
    </header>
    <main>
        <?php
        switch ($_SERVER['REQUEST_URI']) {
            case '/roommates/home':
                require_once __DIR__ . '/html/home.html';
                break;
            case '/roommates/login':
                require_once __DIR__ . '/html/login.html';
                break;
            case '/roommates/registration':
                require_once __DIR__ . '/html/registration.html';
                break;
            case '/roommates/my-profile':
                require_once __DIR__ . '/html/my-profile.html';
                break;
            case '/roommates/display-profile':
                require_once __DIR__ . '/html/display-profile.html';
                break;
        }
        ?>
    </main>
    <script src="../js/displayDataByRole.js"></script>
    <script src="../js/logout.js"></script>
    <script src="../js/findMatchedUsers.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script> -->
</body>

</html>