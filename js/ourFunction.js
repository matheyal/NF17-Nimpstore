function ifEmpty() {

    var input = document.getElementById('adSearch');

    if (input.value.length == 0)
        input.setAttribute("value","0");


}

/*function showResultCombobox(Liste1, Liste2) {

    var select = document.getElementById('1stList');

    select.setAttribute("selected","selected");

    select = document.getElementById('2ndList');

    select.setAttribute("selected","selected");
}
*/
function Lien() {

    var get_id = document.getElementById('Liste');
    console.log(get_id);
    var result = get_id.options[get_id.selectedIndex].value;
    if (result==0) return;
    parent.location.href = result;

}

function fCheckForm(selfLogin) {

var isChecked = document.getElementById('friend').checked;
    if (isChecked) {
        var name = document.getElementById('loginFriend');
        if (name.value.length == 0) {
            parent.location.href = document.location + "&err=1";
            alert("");
            return false;
        }
        if (name.value == selfLogin) {
            parent.location.href = document.location + "&err=2";
            alert("");
            return false;
        }
    }
}

function fDisabInput() {

    var isChecked = document.getElementById('friend').checked;
    var textInput = document.getElementById('loginFriend');
        textInput.disabled = !isChecked;

}

function fPromptCom() {

    var com, note;
    note = prompt("Donnez votre note sur 5");
    com = prompt("Donnez votre avis sur cette appli !");

    valueNote = document.getElementsByTagName("note");
    for (i=0;i<valueNote.length;i++) valueNote[i].setAttribute("value",note);
 
 valueCom = document.getElementsByTagName("com");
    for (i=0;i<valueCom.length;i++) valueCom[i].setAttribute("value",com);

        alert(valueNote[0].getAttribute("value"));
    alert("Bouxaaaa");
}