function ifEmpty() {

    var input = document.getElementById('adSearch');

    if (input.value.length == 0)
        input.setAttribute("value","0");


}

function showResultCombobox(Liste1, Liste2) {

    var select = document.getElementById('1stList');

    select.setAttribute("selected","selected");

    select = document.getElementById('2ndList');

    select.setAttribute("selected","selected");
}