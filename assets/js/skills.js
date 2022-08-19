var e = 0; //for skills

$(document).ready(function () {
    show();
    $("#skillsBtn").click(function () {

        //getting field values
        var skill = $('#skillInput').val();
        var proficiency = $('#skillProgress').val();

        setSkill(skill, proficiency);

        //disable add btn 
        $("#skillsBtn").prop('disabled', true)
        $('#skillProgress').prop('disabled', true)

        //reset field values
        $('#skillInput').val("");
        $('#skillProgress').val('0');
    });

    /*btn functionality start*/
    $("#skillsBtn").prop('disabled', true) //btn is disabled at default
    $('#skillProgress').prop('disabled', true) //range is disabled at default
    //toggle btn and range at input
    $("#skillInput").keyup(function () {
        if ($("#skillInput").val()) {
            $("#skillsBtn").prop('disabled', false)
            $('#skillProgress').prop('disabled', false)
        }
        if (!$("#skillInput").val()) {
            $("#skillsBtn").prop('disabled', true)
            $('#skillProgress').prop('disabled', true)
        }
    });
    /*btn functionality end*/
});

function setSkill(sk, prof) {
    $.ajax({
        method: 'POST',
        url: './scripts/apis/addSkill.php',
        data: `email=${email}&skill=${sk}&prof=${prof}`,
        success: function (data) {
            snackbar(data);
            show();
        }
    })
    changeSite();
}

function show() {
    $.ajax({
        method: 'POST',
        url: './scripts/apis/viewSkills.php',
        data: `email=${email}`,
        success: function (data) {
            e = 0;
            userSkills = data.skills[0]
            if (userSkills) {
                userSkills = data.skills[0].skill;
                $('#yourSkills').empty();
                if (userSkills) {
                    skillsArr = userSkills.split(',');
                    profArr = data.skills[0].prof.split(',');
                    skillsArr.forEach(elem => {
                        $("#yourSkills").append(`<div class='input-group d-flex align-items-center skillDivs' id='skillDiv${e}'><span class='input-group-text col-md-2 col-12 justify-content-center text-wrap text-break' id='skill${e}'>${elem}</span><div class='form-control progressDiv'><div class='progress d-flex align-items-center' style='height: 26px;'><div class='progress-bar' role='progressbar' style='width: ${profArr[e]}%; height: 26px;' aria-valuenow='${profArr[e]}' aria-valuemin='0' aria-valuemax='100' id='progress${e}'>${profArr[e]}%</div></div></div><button class='btn btn-outline-primary' onclick='edit(${e})' id='edit${e}' type='button'><i id='e${e}' class='fa fa-pen'></i></button><button class='btn btn-outline-primary' onclick='del(${e})' id='delete${e}' type='button'><i class='fa fa-trash'></i></button></div>`)
                        e = e + 1;
                    });
                }
            }

        }
    })
}

//on skill delete
function del(a) {
    $.ajax({
        method: 'POST',
        url: './scripts/apis/delSkill.php',
        data: `email=${email}&sid=${a}`,
        success: function (data) {
            snackbar(data);
            show();
        }
    })
    changeSite();
}

//on skill edit
function edit(a) {

    /* edit toggle start */
    var test = $('#e' + a);
    var classList = test.attr('class').split(/\s+/);
    $.each(classList, function (index, item) {
        if (item === 'fa-pen') {
            test.removeClass('fa-pen');
            test.addClass('fa-check');
        }
        if (item === 'fa-check') {
            test.removeClass('fa-check');
            test.addClass('fa-pen');
        }
    });
    /* edit toggle end */

    /* edit section */
    if ($('#skill' + a).attr('type') === 'text') {
        newSkill = $('#skill' + a).val();
        newProf = $('#progress' + a).val();
        $.ajax({
            method: 'POST',
            url: './scripts/apis/editSkills.php',
            data: `email=${email}&sid=${a}&skill=${newSkill}&prof=${newProf}`,
            success: function (data) {
                snackbar(data);
                show();
            }
        });

    } else {
        $('#skill' + a).replaceWith(`<input class="form-group input-text-group col-md-2 col-12 in" type="text" id='skill${a}' value="${$('#skill' + a).text()}">`)
        $('#skill' + a).focus();

        //cursor to the last
        var num = $('#skill' + a).val();
        $('#skill' + a).focus().val('').val(num);

        //replacing progress bar with range
        $('#progress' + a).replaceWith(`<input type="range" class="form-range inProgress" min="0" max="100" step="10" id="progress${a}" value="${$('#progress' + a).attr('aria-valuenow')}">`)
    }
    changeSite();
}