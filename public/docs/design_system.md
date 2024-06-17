# Design Document

## Front-End Components
### Fonts
For this game, we decided to use very minimalist, web-safe fonts like Arial and Courier New. The reason being that the game is quite simple and we want it to be accessible to every machine. This game should not take too long to load and it should be able to easily read.

### Colours
For colours, we decided to use high-contrasting colours because of accessibility. We made all text black and used a white background for the main game area. The game area is a div itself that stretches only 80% of the width of the screen which allows us to fill the other 20% with a Yahtzee-inspired background that is primarily red.

### Dice
For the dice, we created our own dice that had rounded corners, a light grey face, and we positioned dots on each face to represent each of the 6 sides of a dice. Every time a player rolled the dice, we would play an animation where the dice would randomly cycle through faces of the dice before settling on the actual rolled value to make the dice less static. Every time a player kept the dice, the dice would be filled green to indicate that it had been locked in. Refer to [dice.js](/public/assets/dice.js) for the back-end implementation of the dice as a module and [dice.html](/public/assets/design_system/dice.html) for the front-end implementation of the dice as it appears in the game.

## Game Components
### Starting a New Game
To start a game, hit the "Roll" button on the [test.html](/public/test.html) front-end file which will roll all five dice. This will automatically start a new game. If the player had just finished a game, a pop-up lightbox will present their statistics and past scores. The player can simply hit "Play Again" to start a new game and retain their previous scores. Refer to [test.html](/public/test.html) for the front-end and [yatzy_engine.js](/public/assets/yatzy_engine.js) for the back-end.

### Gameplay
To play the game, each turn comprises of up to three rolls. Click on 'Roll' to roll or re-roll the dice. The first roll rolls five dice, each with six sides. For the next two rolls, you can choose whether the value of each dice should be keep (locked) or should be re-rolled. After the turn, you can choose which score box (ex. Ones, Fives, Full House, Chance) to apply your rooster of five dice to. The game will calculate how much you score based on the value of your dice and the chosen score box. You may not choose the same score box after it's already chosen. The game ends after thirteen turns - when the player has filled all their thirteen score boxes - and the game calculates the final score, including possible bonus points. The aim of the game is to get the highest amount of points possible, by utilizing strategy while locking the value of dices, and choosing which score box to apply for a turn. Refer to [test.html](/public/test.html) for the front-end and [yatzy_engine.js](/public/assets/yatzy_engine.js) for the back-end.

### Tracking The Score
Scoring of the game is kept in the [yatzy_engine.js](/public/assets/yatzy_engine.js) file, including saved variables and helper functions. Scoring of a completed game is calculated by the function overallScore(), which adds up the score as well as a bonus of 35 if the upper sections' scoring is equal or more to 63 points. Each turn's scoring is calculated by the function turnScore(), which calculates the turns' score based on the values of the 5 dices and chosen category box (out of 13 score boxes). Refer to [test.html](/public/test.html) for the front-end and [yatzy_engine.js](/public/assets/yatzy_engine.js) for the back-end.
For more specific details on the game's scoring, refer to [Yatzy](https://en.wikipedia.org/wiki/Yatzy).

### Ending The Game
After 13 rounds, the game automatically ends. The player's total score is summed up and stored in a log of the player's past scores, so that the player can compare their overall performance. Refer to [yatzy_game.js](/public/assets/yatzy_game.js) for the Game module's saving function.  
This is displayed in a pop-up lightbox that obscures the screen and presents the player's scores and statistics The player can choose to play again by clicking "Play Again" or clicking the "X" to close the lightbox to review their gameplay. The statistics of past games are always accessible by clicking on the graph button in the upper-right corner. Refer to [test.html](/public/test.html) for the front-end script.