//board
let board; 
let boardW = 360; 
let boardH = 640; 
let context; 

//bird
let brdW = 34;
let brdH = 24;
let brdX = boardW/8;
let brdY = boardH/2;
let brdImg; 
let brdSkin = typeof selectedSkinImage !== 'undefined' ? selectedSkinImage : "./assets/skin/flappybird0.png";

let brd = {
    x: brdX,
    y: brdY, 
    width: brdW, 
    height: brdH
}

//pillar
let pillarArray = [];
let pillarW = 64; 
let pillarH = 512; 
let pillarX = boardW; 
let pillarY = 0; 

let topPillarImg;
let bottomPillarImg;

//gamelogik
let velX = -2; 
let velY = 0; 
let gravity = 0.1; 

let gameOver = true; 
let gameStartedNever = true; 
let score = 0; 
let canRestart = true;

window.onload = function(){
    board = document.querySelector("#screen");
    board.height = boardH; 
    board.width = boardW; 
    context = board.getContext('2d');


    brdImg = new Image(); 
    brdImg.src = brdSkin; 
    brdImg.onload = function(){
        context.drawImage(brdImg, brd.x, brd.y, brd.width, brd.height); 
    }

    topPillarImg = new Image(); 
    topPillarImg.src = "./assets/pillar/toppipe.png"; 

    bottomPillarImg = new Image(); 
    bottomPillarImg.src = "./assets/pillar/bottompipe.png"; 

    requestAnimationFrame(update); 
    setInterval(placePillars, 1500); 
    document.addEventListener("keydown", updateBird)
}

function update(){
    requestAnimationFrame(update); 
    if(gameOver){
        return; 
    }
    context.clearRect(0, 0, board.width, board.height);
    
    velY += gravity; 
    brd.y = Math.max(velY + brd.y, 0); 
    context.drawImage(brdImg, brd.x, brd.y, brd.width, brd.height); 

    if(brd.y > board.height){
        triggerGameOver();
    }

    for(let i = 0; i < pillarArray.length; i++){
        let p = pillarArray[i]; 
        p.x += velX; 
        context.drawImage(p.img, p.x, p.y, p.width, p.height); 

        if(!p.passed && brd.x > p.x + p.width){
            score += 0.5; 
            p.passed = true; 
        }

        if(detectCollision(brd, p)){
            triggerGameOver();
        }
    }

    while(pillarArray.length > 0 && pillarArray[0].x < -pillarW){
        pillarArray.shift();
    }

    context.fillStyle = "black"; 
    context.font = "45px sans-serif"; 
    context.textAlign = "center"; 
    context.fillText(score, board.width / 2, board.height / 8);

    if(gameOver && !gameStartedNever){
        context.fillText("GAME OVER", board.width / 2, 2 * (board.height / 8)); 
    }

}

function placePillars(){
    if(gameOver){
        return; 
    }

    let randY = pillarY - pillarH/4 - Math.random() * (pillarH/2); 
    let space = pillarH/4; 

    let topPillar = {
        img: topPillarImg, 
        x: pillarX, 
        y: randY, 
        width: pillarW, 
        height: pillarH, 
        passed: false
    }

    let bottomPillar = {
        img: bottomPillarImg, 
        x: pillarX, 
        y: randY + pillarH + space, 
        width: pillarW, 
        height: pillarH, 
        passed: false
    }
    pillarArray.push(topPillar); 
    pillarArray.push(bottomPillar); 

}

function updateBird(e){
    if(e.code == "Space"){
        if(!gameOver){
            velY = -3; 
        }
        else if(gameOver && (canRestart || gameStartedNever)){ 
            brd.y = brdY; 
            pillarArray = []; 
            score = 0; 
            velY = 0;
            gameOver = false; 
            gameStartedNever = false; 
            canRestart = false; 
        }
    }
}

function detectCollision(a, b){
    return a.x < b.x + b.width && a.x + a.width > b.x && a.y < b.y + b.height && a.y + a.height > b.y; 
}

function triggerGameOver(){
    if(gameOver) return; 
    gameOver = true; 

    if(score > 0){
        fetch('save_score.php', {
            method: "POST", 
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({score: score })
        }).then(res =>console.log("Score Updated!"));
    }

    setTimeout(function(){
        canRestart = true; 
    }, 500); 

}
