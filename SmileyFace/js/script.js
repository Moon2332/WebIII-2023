
let choisit;
var choix = document.getElementsByName("Choix");
//let envoyer = document.getElementById("envoyer");
let IDTABLE = ["Good", "Neutre", "Bad"];

console.log(choix);

function choice(){
    
    for (let i = 0; i < choix.length; i++)  
    {
            choix[i].addEventListener("change", function() {
            if ( i === choix[i].value)
                choisit = i;
        });  
    }; 



    console.log(choisit);
}













