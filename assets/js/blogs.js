var bar = [];
function createBlogInstance(bar) {
    $('.blogTy').empty();
    const blog = [
        {
            label: "Design",
            value: "Design",
        },
        {
            label: "Development",
            value: "Development",
        },
        {
            label: "Travel",
            value: "Travel",
        },
        {
            label: "Food",
            value: "Food",
        },
        {
            label: "Fashion",
            value: "Fashion",
        },
    ]

    var instance2 = new SelectPure(".blogTy",{
        options: blog,
        multiple: true,
        placeholder: "select blog type...",
        autocomplete: true,
        value: (bar.length ? bar : false),
        icon: "fa fa-times",
        inlineIcon: false,
        onChange: value => {
            var arr2 = changes2();
            $('#blogType').val(arr2)
        }
    });

    function changes2(){
        var arr2 = []
        var selected = instance2.value()  //selected instance 
        selected.forEach(s => arr2.push(s))
        return arr2
    }

}

$(document).ready(function () {
    $('#blogBtn').prop('disabled', true) //btn is disabled at default
    $('#blogTopic').keyup(function(){
        if($("#blogTopic").val()){
            $("#blogBtn").prop('disabled', false)
        }
        if(!$("#blogTopic").val()){
            $("#blogBtn").prop('disabled', true)
        }
    })
    blogShow();
    createBlogInstance(bar);
})

function blogShow() {
    $.ajax({
        method: 'POST',
        url: './scripts/apis/viewBlogs.php',
        data: `email=${email}`,
        success: function (data) {
            $('#myBlogs').empty();
            userBlogs = data.blogs; 
            if (userBlogs) {
                userBlogs.forEach(elem => {
                    $('#myBlogs').append(`<div class="mb-3 col-12 col-md-3 card myProject" id='blog${elem.id}'><img src="./userImg/${email}/blogs/${elem.bName}/${elem.bImage}" class="card-img-top" id='pImg${elem.id}'><div class="card-body row align-items-center"><h5 class="card-title" id='blogName${elem.id}'>${elem.bName}</h5><p class="card-text" id='blogDetails${elem.id}'>${elem.bDetails}</p><div class='card-footer'><a href='${elem.bLink}' id='blogLink${elem.id}' class='card-link justify-content-center'>${elem.bLink}</a><div class="row justify-content-center mt-2"><button class="btn btn-outline-primary col-6" type="button" style="margin-left: 0px !important; width: 48%;" id='bedit${elem.id}' onclick='bedit(${elem.id})'>Edit</button><button class="btn btn-outline-danger col-6" type="button" style="margin-left: 4px !important; width: 48%;" id='bdel${elem.id}' onclick='bdel(${elem.id})'>Delete</button></div></div></div></div>`)
                })
            }
        }
    })
}


//add project
$("#blogBtn").click(function (e) {
    
    $('#blogTopic').prop('disabled', false);
    e.preventDefault();
    let blogForm = $("#blogForm")[0];
    let formdata = new FormData(blogForm);
    $('#blogTopic').prop('disabled', true);
    formdata.append('email', email);
    if($("#blogBtn").text() == "✔ Save Blog"){
        myurl = './scripts/apis/editBlog.php';
        formdata.append('id', bid);
    }else{
        myurl = './scripts/apis/addBlog.php';
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
            blogShow();

            //empty fields after addition
            if (data.status == true) {
                $('#blogTopic').val('');
                createBlogInstance(bar);
                $('#blogDetails').val('');
                $('#blogLink').val('');
                $('#blogImages').val('');
                $('#blogImgLabel').text('jpeg, png, webp...');
                $("#blogBtn").text("+ Add blog");
                $("#blogBtn").prop('disabled', true);
                $('#blogTopic').prop('disabled', false);
            }
            snackbar(data);
        },
        error: function (e) {
            console.log("ERROR : ", e);
        }
    }) 
    changeSite();
});

//project del
function bdel(a) {
    $.ajax({
        method: 'POST',
        url: './scripts/apis/delBlog.php',
        data: `bid=${a}`,
        success: function (data) {
            blogShow();
            snackbar(data);
        }
    })
    changeSite();
}

//project edit
function bedit(a) {
    bid = a;
    userBlogs.forEach(m => {
        if (m.id == a) {
            btoEdit = m;
        }
    });

    //pdel(toEdit['id']);

    $('#blogTopic').val(btoEdit['bName']);
    $('#blogTopic').prop('disabled', true);
    $('#blogDetails').val(btoEdit['bDetails']);
    $('#blogType').val(btoEdit['bType']);
    $('#blogLink').val(btoEdit['bLink']);
    $('#blogImgLabel').text(btoEdit['bImage']);
    document.documentElement.scrollIntoView();

    btype = btoEdit['bType'] ? btoEdit['bType'].split(',') : '';
    createBlogInstance(btype);

    $("#blogBtn").text("✔ Save Blog");
    $("#blogBtn").prop('disabled', false);
}

function activeBlogFile() {
    $('#blogImages').trigger('click');
}

$('#blogImages').change(() => {
    bim = $('#blogImages')[0].files.item(0).name;
    $('#blogImgLabel').text(bim);
})



