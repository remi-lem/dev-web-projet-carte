const BOARD_SIZE = 10;
const SHIP_COUNT = 5;
const SHIP_LENGTHS = [5, 4, 3, 3, 2];

let board = [];
let ships = [];
console.log(ships);
// Créer le tableau et le remplir de cases vides
function createBoard() {
    for (let i = 0; i < BOARD_SIZE; i++) {
        board[i] = [];
        for (let j = 0; j < BOARD_SIZE; j++) {
            board[i][j] = "";
        }
    }
}

// Placer les navires aléatoirement sur le tableau
function placeShips() {
    for (let i = 0; i < SHIP_COUNT; i++) {
        let shipLength = SHIP_LENGTHS[i];
        let ship = {};
        ship.positions = [];
        ship.hits = [];
        ship.isSunk = false;
        let isVertical = Math.random() < 0.5;
        let x, y;
        let collisionDetected = false;

        do {
            collisionDetected = false;
            if (isVertical) {
                x = Math.floor(Math.random() * BOARD_SIZE);
                y = Math.floor(Math.random() * (BOARD_SIZE - shipLength + 1));
            } else {
                x = Math.floor(Math.random() * (BOARD_SIZE - shipLength + 1));
                y = Math.floor(Math.random() * BOARD_SIZE);
            }
            // Vérifier si la position de chaque partie du navire ne chevauche pas avec les positions d'un autre navire existant
            for (let j = 0; j < shipLength; j++) {
                if (isVertical) {
                    if (board[x][y+j] !== "") {
                        collisionDetected = true;
                        break;
                    }
                } else {
                    if (board[x+j][y] !== "") {
                        collisionDetected = true;
                        break;
                    }
                }
            }
        } while (collisionDetected);

        for (let j = 0; j < shipLength; j++) {
            if (isVertical) {
                board[x][y+j] = i;
                ship.positions.push([x, y + j]);
            } else {
                board[x+j][y] = i;
                ship.positions.push([x + j, y]);
            }
            ship.hits.push(false);
        }
        ships.push(ship);
    }
}


// Afficher le tableau de jeu
function displayBoard() {
    let table = document.getElementById("board");
    table.innerHTML = "";
    for (let i = 0; i < BOARD_SIZE; i++) {
        let row = table.insertRow(i);
        for (let j = 0; j < BOARD_SIZE; j++) {
            let cell = row.insertCell(j);
            cell.addEventListener("click", function() {handleCellClick(i, j);});
            cell.setAttribute("data-row", i);
            cell.setAttribute("data-col", j);
            if (board[i][j] === "hit") {
                cell.classList.add("hit");
            } else if (board[i][j] === "miss") {
                cell.classList.add("miss");
            }
        }
    }
}

// Gérer le clic sur une case
function handleCellClick(row, col) {
    let cellValue = board[row][col];

    if (cellValue === "hit" || cellValue === "miss") {
        showMessage("Déjà ciblé!");
    } else {
        let hitShip;
        for (let i = 0; i < ships.length; i++) {
            let ship = ships[i];
            for (let j = 0; j < ship.positions.length; j++) {
                let pos = ship.positions[j];
                if (pos[0] === row && pos[1] === col) {
                    hitShip = ship;
                    hitShip.hits[j] = true;
                    board[row][col] = "hit";
                    break;
                }
            }
            if (hitShip) {
                break;
            }
        }

        if (hitShip) {
            displayBoard();
            if (isSunk(hitShip)) {
                showMessage("Vous avez coulé un navire!");
            } else {
                showMessage("Touché!");
            }
        } else {
            board[row][col] = "miss";
            displayBoard();
            showMessage("Miss!");
            let cell = document.querySelector(`[data-row="${row}"][data-col="${col}"]`);
            cell.classList.add("miss");
        }
    }
    checkGameOver();
}

// Vérifier si un navire est coulé
function isSunk(ship) {
    for (let i = 0; i < ship.hits.length; i++) {
        if (!ship.hits[i]) {
            return false;
        }
    }
    ship.isSunk = true;
    return true;
}
// Vérifier si la partie est terminée
function checkGameOver() {
    let allSunk = true;
    for (let i = 0; i < ships.length; i++) {
        if (!ships[i].isSunk) {
            allSunk = false;
            break;
        }
    }
    if (allSunk) {
        showMessage("Vous avez gagné!");
        alert("Vous avez gagné!");
    }
}
// Afficher un message à l'utilisateur
function showMessage(msg) {
    let messageElement = document.getElementById("message");
    messageElement.textContent = msg;
}
// Initialiser la partie
function init() {
    createBoard();
    placeShips();
    displayBoard();
    console.log("go");
}
init();
