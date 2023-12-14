let queue = [];
const lenghtTab = 10;
const code = ["ArrowUp", "ArrowUp", "ArrowDown", "ArrowDown", "ArrowLeft", "ArrowRight", "ArrowLeft", "ArrowRight", "B", "A"];

document.addEventListener("keydown", function(e){
    check(e);
});

function check(e) {
    if(e.key !== "Shift") {
        majTab(e);
        if (e.key === "a" || e.key === "A") {
            if (testCombinaison()) {
                windowChanges();
            }
        }
    }
}

function testCombinaison(){
    for (let i=0; i < lenghtTab; i++){
        if (queue[i].toUpperCase() !== code[i].toUpperCase()){
            return false;
        }
    }
    return true;
}

function windowChanges(){
    window.location.href = 'konami.php';
}

function majTab(e) {
    if (queue.length >= lenghtTab) {
        queue.shift();
        queue.push(e.key);
    }
    else {
        queue.push(e.key);
    }
}