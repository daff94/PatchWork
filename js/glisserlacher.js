// Javascript - Gestion du glisser-lacher

window.onload=function(){
    var depot = document.querySelector('.valise')
    depot.addEventListener('dragover',dragOverEvent, false)
    depot.addEventListener('drop',dropEvent, false)
}

function addElement() {
    console.log("fonction appelée");
    var newImg = document.createElement("img");
    newImg.src = "images/photo(2).jpg";
    // var newContent = document.createTextNode("coucou");
    // newDiv.appendChild(newImg);
    document.getElementById('div1').appendChild(newImg);

    // var currentDiv = document.getElementById("img1");
    // document.body.insertBefore(newDiv,currentDiv);
}

function dragOverEvent(e){
    e.preventDefault()
}

function dropEvent(e){
    var liste = e.dataTransfer.files
    console.log(e.dataTransfer.files)
    for (let file of e.dataTransfer.files) {
        if (file.type == 'image/jpeg') {
            console.log(file.name)
            addElement();
        }
    }
    e.preventDefault()
}

