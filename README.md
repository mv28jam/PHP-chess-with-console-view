# Console chess made with PHP 
8 ♖ ♘ ♗ ♕ ♔ ♗ ♘ ♖  
7 ♙ ♙ ♙ ♙ ♙ ♙ ♙ ♙  
6&nbsp; ■&nbsp; □&nbsp; ■&nbsp; □&nbsp; ■&nbsp; □&nbsp; ■&nbsp; □  
5&nbsp; ■&nbsp; □&nbsp; ■&nbsp; □&nbsp; ■&nbsp; □&nbsp; ■&nbsp; □  
4&nbsp; ■&nbsp; □&nbsp; ■&nbsp; □&nbsp; ■&nbsp; □&nbsp; ■&nbsp; □  
3&nbsp; ■&nbsp; □&nbsp; ■&nbsp; □&nbsp; ■&nbsp; □&nbsp; ■&nbsp; □  
2 ♟ ♟ ♟ ♟ ♟ ♟ ♟ ♟  
1 ♜ ♞ ♝ ♛ ♚ ♝ ♞ ♜  
&nbsp;&nbsp;&nbsp;a &nbsp;&nbsp;b &nbsp;c &nbsp;&nbsp;d &nbsp;e &nbsp;&nbsp;f &nbsp;g &nbsp;&nbsp;h  
Input move:1. f2-f3 e7-e5 2. g2-g4?? Фd8-h4x

## Install
mkdir php-chess  
cd ./php-chess  
git clone git@github.com:mv28jam/PHP-chess-with-console-view.git ./  
composer install --no-dev  

## Play
./chess

## Tests
composer install --dev  
php vendor/bin/codecept run

## TODO:
- tests more
- making smarter bot 
