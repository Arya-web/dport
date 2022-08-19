$('#createSite').on('click', function () {
    changeSite();
})

function changeSite() {
    $.ajax({
        method: "POST",
        url: "./scripts/apis/createSite.php",
        data: `email=${email}`,
        success: function (data) {
            $('#siteHref').attr('href', data.response)
            $('#mysite').text('www.dport.com/Arya Shreyas')
        },
        error: function (e) {
            console.log(e);
        }
    })
}

temp_selected = document.querySelectorAll(".temp");
temp_selected.forEach(e => {
    e.addEventListener("click", () => {
        temp_selected.forEach(f => f.classList.remove("temp_selected"));
        e.classList.add('temp_selected');
    })
});
