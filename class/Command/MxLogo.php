<?php

namespace Command;

use Mizi\Terminal;

abstract class MxLogo extends Terminal
{
    protected static function execute()
    {
        Terminal::show("#@@.   ,@@* /@@  %@&       #@@@@@@@. #@@.   ,@@  #@@@@@@\\");
        Terminal::show("#@@&   @@@*  %@#,@@        #@&   &@. #@@&   @@@  #@&  \&@\\");
        Terminal::show("#@@@, /@@@*   @@@@,        #@&   ,,  #@@@, /@@@  #@&   &@%");
        Terminal::show("#@%@@.@&&@*   .@@#     @@  #@&       #@%@@.@&&@  #@&   &@%");
        Terminal::show("#@%*@@@.&@*   @@@@,   @@@@ #@&       #@%*@@@.&@  #@&   &@%");
        Terminal::show("#@% @@% &@*  %@%,@@    @@  #@&   &@. #@% @@& &@  #@&   &@%");
        Terminal::show("#@% *@. &@* *@@  %@%       #@&,,,&@. #@% *@. &@  #@&,,/@@%");
        Terminal::show("#@%     &@*.@@*   @@/      \@@@@@@@  #@%     &@  #@@@@@&/");
    }
}