function ifEmpty() {

    var input = document.getElementById('adSearch');

    if (input.value.length == 0)
        input.setAttribute("value","0");


}