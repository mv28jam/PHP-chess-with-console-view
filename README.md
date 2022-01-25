# Console chess made with PHP (interactive)
No "bot", only game mechanics. 

8 ♖ ♘ ♗ ♕ ♔ ♗ ♘ ♖   
7 ♙ ♙ ♙ ♙ ♙ ♙ ― ♙   
6 ― ― ― ― ― ― ― ―   
5 ― ♟ ― ― ― ― ― ―   
4 ― ― ― ― ― ― ― ―   
3 ― ― ― ― ― ― ― ♙   
2 ♟ ― ♟ ♟ ♟ ♟ ♟ ―   
1 ♜ ♞ ♝ ♛ ♚ ♝ ♞ ♜   
&nbsp; a&nbsp; b&nbsp; c&nbsp; d&nbsp; e&nbsp; f&nbsp; g&nbsp; h   
Input move:b2-b4|g7-g5|b4-b5|g5-g4|h2-h4|g4-h3  


### TODO:
- Move structure redo - one "move" = multiple figures position change (complex move like Roque does not fit good)
- Roque limitation check
- King move complex limitation check
- Notation by standart support (std notation like e2-e4 a7-a6 Rh1-h2 )
- Support loading of "pawn to queen convertation" from multiple move input
- Save game function / load game function
- Bot (price + random)
