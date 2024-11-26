// Javascript - Gestion du glisser-lacher

window.onload=function(){
    var depot = document.querySelector('.valise')
    depot.addEventListener('dragover',dragOverEvent, false)
    depot.addEventListener('drop',dropEvent, false)
}


function dragOverEvent(e){
    e.preventDefault()
}

function dropEvent(e){
    var liste = e.dataTransfer.files
    for (let file of e.dataTransfer.files) {
        if (file.type == 'image/jpeg') {
            var newImg = document.createElement("img");
            newImg.src = "images/" + file.name;
            document.getElementById('div1').appendChild(newImg);
        }
    }
    e.preventDefault()
}

