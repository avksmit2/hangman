<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/hangman.php";

    session_start();
    if (empty($_SESSION['list_of_words'])) {
        $_SESSION['list_of_words'] = array();
    }
    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    $newWord = new Word("return", "verb");
    $newWord->saveWords();
    $newWord = new Word("efficient", "adjective");
    $newWord->saveWords();

    $app->get("/", function() use($app) {

        return $app['twig']->render('start.html.twig', array('words' => $_SESSION['list_of_words']));
    });

    $app->get("/begin", function() use($app) {
        $newGame = new Game();
        $i = rand(0, count($_SESSION['list_of_words']) - 1);
        $newGame->setCurrentWord($_SESSION['list_of_words'][$i]->getWord());

        $newGame->saveGame();

        return $app['twig']->render('game.html.twig', array('game' => $_SESSION['game']));
    });

    $app->post("/guess", function() use ($app) {
        $letter = $_POST['letter'];
        $game = $_SESSION['game'];
        $message = "Guess a letter!";

        if (!in_array($letter, $game->getGuessCorrectChar())
            && !in_array($letter, $game->getGuessWrongChar())
            && !in_array($letter, $game->getCurrentWord()))
        {
            $message = 'Sorry, try again!';
            $game->setGuessWrongChar($letter);
            $game->setGuessNum($game->getGuessNum()+1);
        } elseif (!in_array($letter, $game->getGuessCorrectChar())
            && !in_array($letter, $game->getGuessWrongChar())
            && in_array($letter, $game->getCurrentWord())) {
            $message = 'Yay! You guessed a correct letter!';
            $game->setGuessCorrectChar($letter);
        } elseif (!in_array($letter, $game->getGuessCorrectChar())
            && in_array($letter, $game->getGuessWrongChar())
            && !in_array($letter, $game->getCurrentWord())) {
            $message = 'Doh! You already guessed that letter, and it was WRONG!';
        } elseif (in_array($letter, $game->getGuessCorrectChar())
            && !in_array($letter, $game->getGuessWrongChar())
            && !in_array($letter, $game->getCurrentWord())) {
                $message = 'Doh! You already guessed that letter, and it was CORRECT!';
        }

        return $app['twig']->render('game.html.twig', array('game' => $_SESSION['game'], 'message'=>$message));
    });

    return $app;
?>
