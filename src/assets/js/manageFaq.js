function deleteQuestion(id){
    //l'utilisateur veut supprimer une question
    document.querySelector("div#div"+id).hidden=true;//on cache la question
    document.querySelector("#r"+id).value="yes";

}
