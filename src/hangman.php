<?php
class Game
{
    private $currentWord;
    private $guessNum;
    private $guessWrongChar;
    private $guessCorrectChar;
    private $gameOver;

    function __construct()
    {
        $this->currentWord = array();
        $this->guessNum = 0;
        $this->guessWrongChar = array();
        $this->guessCorrectChar = array();
        $this->gameOver = false;
    }

    function setCurrentWord($new_currentWord)
    {
        $this->currentWord = str_split($new_currentWord);
    }
    function setGuessNum($new_guessNum)
    {
        $this->guessNum = $new_guessNum;
    }
    function setGuessWrongChar($new_guessWrongChar)
    {
        array_push($this->guessWrongChar, $new_guessWrongChar);
    }
    function setGuessCorrectChar($new_guessCorrectChar)
    {
        array_push($this->guessCorrectChar, $new_guessCorrectChar);
    }
    function setGameOver($new_gameOver)
    {
        $this->gameOver = $new_gameOver;
    }

    function getCurrentWord()
    {
        return $this->currentWord;
    }
    function getGuessNum()
    {
        return $this->guessNum;
    }
    function getGuessWrongChar()
    {
        return $this->guessWrongChar;
    }
    function getGuessCorrectChar()
    {
        return $this->guessCorrectChar;
    }
    function getGameOver()
    {
        return $this->gameOver;
    }

    function saveGame()
    {
        $_SESSION['game'] = $this;
    }

}

class Word
{
    private $word;
    private $wordType;

    function __construct($word, $wordType)
    {
        $this->word = $word;
        $this->wordType = $wordType;
    }

    function setWord($new_word)
    {
        $this->word = $new_word;
    }
    function setWordType($new_wordType)
    {
        $this->wordType = $new_wordType;
    }

    function getWord()
    {
        return $this->word;
    }
    function getWordType()
    {
        return $this->wordType;
    }

    function saveWords()
    {
        array_push($_SESSION['list_of_words'], $this);
    }

    // function deleteWord()
    // {
    //     return array_slice($this)
    // }

    static function getWords()
    {
        return $_SESSION['list_of_words'];
    }
}
?>
