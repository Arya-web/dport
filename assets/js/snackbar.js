
var snack = $("#snackbar");

function snackbar(data) {
    snack.empty();
    snack.append(data['response']);
    snack[0].className = "show";
    setTimeout(function () { snack[0].className = snack[0].className.replace("show", ""); }, 3000)
}