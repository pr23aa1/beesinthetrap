<?php
declare(strict_types=1);

namespace App\Constants;

/*
 * This file is part of the Hive Game
 *
 * (c) P Winterhalder <paul@pr23.co.uk>
 *
 */
interface Strings
{
    const INTRO = "###### Bees In The Trap ######\n";
    const INTRO_1 = "As imagined  P Winterhalder\n";
    const INTRO_2 = "Type 'hit' then <enter> to play each turn\n";
    const INTRO_3 = "Type 'quit' then <enter> to play each turn\n\n";
    
    const MSG_NO_HIT = 'Sorry, you hit nothing this time';
    const MSG_HIT = 'You hit a %s, %d point have been deducted';
    const MSG_GAME_OVER = 'Game over, you destroyed the Hive';
    const NO_HIT_DETECTED = 'Sorry, No hit was detected';
    const MSG_GAME_QUIT = 'Game quit, you needed %d points to destroy the Hive';
    const MSG_CMD_NOT_FOUND = "Command '%s' not found";
    const CMD_HASH = 'cmd# ';
    const CMD_HIT = 'hit';
    const CMD_QUIT = 'quit';
    const LINE_RETURN = "\n";
    const NO_BEE_IN_HIVE = "No bees found in the hive!";
}
