<?php
declare(strict_types=1);

namespace App\Classes;

use App\Constants\Strings;
use App\Constants\Status;

/*
 * This file is part of the Hive Game
 *
 * (c) P Winterhalder <paul@pr23.co.uk>
 *
 */
class Application
{

    const DIFFICULTY_LEVEL_EASY = 20;
    const MSG_NO_HIT = 'noHit';
    const MSG_HIT = 'hit';
    const MSG_GAME_OVER = 'gameOver';
    const MSG_GAME_QUIT = 'gameQuit';
    const MSG_CMD_NOT_FOUND = 'cmdNotFound';
    
    /**
     * The status of the game terminal command
     *
     * @var String
     */
    private $status = Status::APP_CONTINUE;
    
    /**
     * The hive object
     *
     * @var App\Classes\Hive
     */
    private $hive;
    
    /**
     * The decision to use stdin or default command
     *
     * @var mixed [String or Null]
     */
    private $stdin = null;
    
    /**
     * The difficulty set the max value for the mt_rand function
     * for use against modulus operator
     *
     * @var int
     */
    private $difficulty;
    
    /**
     * The message string to display at the game terminal
     *
     * @var string
     */
    private $message = "";
    
    /**
     * An array of the application message
     *
     * @var array
     */
    private $messages = [ self::MSG_NO_HIT => Strings::MSG_NO_HIT,
                          self::MSG_HIT => Strings::MSG_HIT,
                          self::MSG_GAME_OVER => Strings::MSG_GAME_OVER,
                          self::MSG_GAME_QUIT => Strings::MSG_GAME_QUIT,
                          self::MSG_CMD_NOT_FOUND => Strings::MSG_CMD_NOT_FOUND,
                        ];
    
    /**
     * Subroutine to handle DI
     *
     * @param App\Classes\Hive The hive object
     * @param mixed $stdin     The decision to use stdin or default command
     * @param int $difficulty  The difficulty level, the higher the number the hard the game
     */
    public function __construct(Hive $hive, ?string $stdin, int $difficulty = self::DIFFICULTY_LEVEL_EASY)
    {
        $this->hive = $hive;
        $this->difficulty = $difficulty;
        $this->stdin = $stdin;
    }

    /**
     * Print a freindly description intro to the game
     *
     * @return void
     */
    public function echoGameIntro(): void
    {
        echo Strings::INTRO;
        echo Strings::INTRO_1;
        echo Strings::INTRO_2;
        echo Strings::INTRO_3;
    }
    
    /**
     * A recursive function for each user input
     * One the game is complete this will exit
     *
     * @return void
     */
    public function run(): void
    {
        echo Strings::CMD_HASH;
        
        $f = $this->getInput();
        
        if ($f == Strings::CMD_QUIT) {
            echo $this->writeQuitMessage(self::MSG_GAME_QUIT, $this->hive->showScoreNeeded());
            $this->terminate();
        } elseif ($f == Strings::CMD_HIT) {
            $rand = mt_rand(1, $this->difficulty);
            $hit = $this->hive->detectHit($rand);
            
            if ($hit == true) {
                $hitPerform = $this->hive->performHit();
                
                if ($hitPerform == true) {
                    if ($this->hive->getGameOver() == true) {
                        echo $this->writeMessage(self::MSG_GAME_OVER);
                        $this->terminate();
                    } else {
                        echo $this->writeHitMessage(
                            self::MSG_HIT,
                            $this->hive->showHitBeeName(),
                            $this->hive->showHitBeePoints()
                        );
                        
                        $this->nextRun();
                    }
                } else {
                    echo $this->writeMessage();
                    $this->nextRun();
                }
            } else {
                echo $this->writeMessage();
                $this->nextRun();
            }
        } else {
            echo $this->writeNoticeMessage(
                self::MSG_CMD_NOT_FOUND,
                $f
            );
                        
            $this->nextRun();
        }
    }

    /**
     * Write a simple message to the game terminal
     *
     * @param string $key The array key for the string
     *
     * @return string
     */
    public function writeMessage(string $key = self::MSG_NO_HIT): string
    {
        return $this->messages[$key] . Strings::LINE_RETURN;
    }
    
    /**
     * Write a message to the game terminal when a hit is made
     *
     * @param string $key The array key for the string
     * @param int $i      The integer value to substitute
     *
     * @return string
     */
    public function writeNoticeMessage(string $key, string $s): string
    {
        return sprintf($this->messages[$key], $s) . Strings::LINE_RETURN;
    }
    
    /**
     * Write a message to the game terminal when a hit is made
     *
     * @param string $key The array key for the string
     * @param int $i      The integer value to substitute
     *
     * @return string
     */
    public function writeQuitMessage(string $key, int $i): string
    {
        return sprintf($this->messages[$key], $i) . Strings::LINE_RETURN;
    }
    
    /**
     * Write a message to the game terminal when a hit is made
     *
     * @param string $key The array key for the string
     * @param string $s   The string value to substitute
     * @param int $i      The integer value to substitute
     *
     * @return string
     */
    public function writeHitMessage(string $key, string $s, int $i): string
    {
        return sprintf($this->messages[$key], $s, $i) . Strings::LINE_RETURN;
    }
    
    /**
     * Get the status of the game
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
    
    /**
     * Get the input either by STDIN or a default string
     *
     * @return string
     */
    private function getInput(): string
    {
        $c = '';
        
        if ($this->stdin == null) {
            while ($f = trim(fgets(STDIN))) {
                return $f;
            }
        } else {
            $c = $this->stdin;
        }
        
        return $c;
    }
    
    /**
     * Set the status to continue
     * and perform run method
     *
     * @return void
     */
    private function nextRun(): void
    {
        $this->status = Status::APP_CONTINUE;
        
        if ($this->stdin == null) {
            $this->run();
        }
    }
    
    /**
     * Set the status to terminate
     * and exit the app
     *
     * @return void
     */
    private function terminate(): void
    {
        $this->status = Status::APP_TERMINATE;
        
        if ($this->stdin == null) {
            exit(0);
        }
    }
}
