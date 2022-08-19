$(document).ready(function () {
    $('#tesBtn').prop('disabled', true) //btn is disabled at default
    $('#tesName').keyup(function(){
        if($("#tesName").val()){
            $("#tesBtn").prop('disabled', false)
        }
        if(!$("#tesName").val()){
            $("#tesBtn").prop('disabled', true)
        }
    })
    tesShow();
})

function tesShow() {
    $.ajax({
        method: 'POST',
        url: './scripts/apis/viewTes.php',
        data: `email=${email}`,
        success: function (data) {
            $('#myTes').empty();
            userTes = data.tes;
            if (userTes) {
                userTes.forEach(elem => {
                    $('#myTes').append(`<div class="mb-3 col-md-4 col-12 card myProject" id='tes${elem.id}'><img src="./userImg/${email}/tes/${elem.tesName}/${elem.tesImage}" class="card-img-top" id='tesImg${elem.id}'><div class="card-body row align-items-center"><h5 class="card-title" id= 'tesName${elem.id}'>${elem.tesName}</h5><p class="card-text" id='tesDetails${elem.id}'>${elem.tesDetails}</p><div class='card-footer'><p class="card-text" id='tesCred${elem.id}'>${elem.tesCred}</p><div class="row justify-content-center mt-2"><button class="btn btn-outline-primary col-6" type="button" style="margin-left: 0px !important; width: 48%;" id='tedit${elem.id}' onclick='tedit(${elem.id})'>Edit</button><button class="btn btn-outline-danger col-6" type="button" style="margin-left: 4px !important; width: 48%;" id='tdel${elem.id}' onclick='tdel(${elem.id})'>Delete</button></div></div></div></div>`)
                })
            }
        }
    })
}


//add testimonial
$("#tesBtn").click(function (e) {
    
    $('#tesName').prop('disabled', false);
    e.preventDefault();
    let tesForm = $("#tesForm")[0];
    let formdata = new FormData(tesForm);
    $('#tesName').prop('disabled', true);
    formdata.append('email', email);
    if($("#tesBtn").text() == "✔ Save Changes"){
        myurl = './scripts/apis/editTes.php';
        formdata.append('id', tid);
    }else{
        myurl = './scripts/apis/addTes.php';
    }
    $.ajax({
        method: 'POST',
        enctype: 'multipart/form-data',
        url: myurl,
        data: formdata,
        processData: false,
        contentType: false,
        cache: false,
        success: function (data) {
            tesShow();

            //empty fields after addition
            if (data.status == true) {
                $('#tesName').val('');
                $('#tesDetails').val('');
                $('#tesCred').val('');
                $('#tesImages').val('');
                $('#tesImgLabel').text('jpeg, png, webp...');  
                $("#tesBtn").text("+ Add testimonial");
                $("#tesBtn").prop('disabled', true);
                $('#tesName').prop('disabled', false);
            }
            snackbar(data);
        },
        error: function (e) {
            console.log("ERROR : ", e);
        }
    }) 
    changeSite();
});

//testimonial del
function tdel(a) {
    $.ajax({
        method: 'POST',
        url: './scripts/apis/delTes.php',
        data: `tid=${a}`,
        success: function (data) {
            snackbar(data);
            tesShow();
        }
    })
    changeSite();
}

//testimonial edit
function tedit(a) {
    tid = a;
    userTes.forEach(m => {
        if (m.id == a) {
            testoEdit = m;
        }
    })

    $('#tesName').val(testoEdit['tesName']);
    $('#tesName').prop('disabled', true);
    $('#tesDetails').val(testoEdit['tesDetails']);
    $('#tesCred').val(testoEdit['tesCred']);
    $('#tesImgLabel').text(testoEdit['tesImage']);
    document.documentElement.scrollIntoView();

    $("#tesBtn").text("✔ Save Changes");
    $("#tesBtn").prop('disabled', false);
}

function activeTesFile() {
    $('#tesImages').trigger('click');
}

$('#tesImages').change(() => {
    pim = $('#tesImages')[0].files.item(0).name;
    $('#tesImgLabel').text(pim)
})



