function createUserSkillsInstance(ar) {
    $('.dropdown').empty();
    const myOptions = [
        {
            label: "Freelancer",
            value: "Freelancer",
        },
        {
            label: "Developer",
            value: "Developer",
        },
        {
            label: "Designer",
            value: "Designer",
        },
        {
            label: "Photograper",
            value: "Photograper",
        },
    ];

    var instance = new SelectPure(".dropdown", {
        options: myOptions,
        multiple: true,
        placeholder: "select your profession...",
        autocomplete: true,
        value: (ar.length ? ar:false),
        icon: "fa fa-times",
        inlineIcon: false,
        onChange: value => {
            var arr = changes();
            $('#skills').val(arr)
        }
    });

    function changes() {
        arr = [];
        var selected = instance.value()  //selected instance 
        selected.forEach(s => arr.push(s))
        return arr
    }
};


nm = $('#userName');
abt = $('#aboutUser');
te = $('#skills');

//sends values to db
$('#userBtn').on('click', function () {
    let userForm = $('#userForm')[0];
    let formdata = new FormData(userForm);
    formdata.append('email', email);
    $.ajax({
        method: 'POST',
        url: './scripts/apis/updateUser.php',
        data: formdata,
        processData: false,
        contentType: false,
        cache: false,
        success: function (data) {
            updateDetails();
            snackbar(data);
        }
    })
    changeSite();
})

//fetches and updates
function updateDetails() {
    $.ajax({
        method: 'POST',
        url: './scripts/apis/viewUser.php',
        data: `email=${email}`,
        success: function (data) {
            users = data.user[0];
            nm.val(users['name']);
            abt.val(users['about']);
            te.val(users['techstack']);
            user = users['techstack']?users['techstack'].split(','):'';
            createUserSkillsInstance(user);
            $('#userImg')
                .attr('src', `./userImg/${email}/user/${users['userImage']}`)
                .width(134)
                .height(134);
            if(users['site'] != null){
            $('#mysite').text(users['site']);}
        }
    })
    changeSite();
}

window.onload = () => {
    updateDetails()
}

function activeUser(){
    $('#userImages').trigger('click');
}

function userImgChange(input){
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#userImg')
                .attr('src', e.target.result)
                .width(134)
                .height(134);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
