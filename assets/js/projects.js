var ar = [];
function createPTechInstance(ar) {
  $(".techStack").empty();
  const tech = [
    {
      label: "Html",
      value: "html",
    },
    {
      label: "CSS",
      value: "css",
    },
    {
      label: "Javascript",
      value: "js",
    },
    {
      label: "Ruby",
      value: "ruby",
    },
    {
      label: "Node.js",
      value: "nodejs",
    },
    {
      label: "React",
      value: "react",
    },
  ];

  var instance1 = new SelectPure(".techStack", {
    options: tech,
    multiple: true,
    placeholder: "select tech used...",
    autocomplete: true,
    value: ar.length ? ar : false,
    icon: "fa fa-times",
    inlineIcon: false,
    onChange: (value) => {
      var arr1 = changes1();
      $("#techStack").val(arr1);
    },
  });

  function changes1() {
    var arr1 = [];
    var selected = instance1.value(); //selected instance
    selected.forEach((s) => arr1.push(s));
    return arr1;
  }
}

$(document).ready(function () {
  $("#projectBtn").prop("disabled", true); //btn is disabled at default
  $("#projectName").keyup(function () {
    if ($("#projectName").val()) {
      $("#projectBtn").prop("disabled", false);
    }
    if (!$("#projectName").val()) {
      $("#projectBtn").prop("disabled", true);
    }
  });
  projectShow();
  createPTechInstance(ar);
});

function projectShow() {
  $.ajax({
    method: "POST",
    url: "./scripts/apis/viewProjects.php",
    data: `email=${email}`,
    success: function (data) {
      $("#myProjects").empty();
      userProjects = data.projects;
      if (userProjects) {
        userProjects.forEach((elem) => {
          $("#myProjects").append(
            `<div class="mb-3 col-12 col-md-3 card myProject" id='project${elem.id}'><img src="./userImg/${email}/projects/${elem.pName}/${elem.pImage}" class="card-img-top img-fluid" id='pImg${elem.id}'><div class="card-body row align-items-center"><h5 class="card-title" id='projectName${elem.id}'>${elem.pName}</h5><p class="card-text" id='projectDetails${elem.id}'>${elem.pDetails}</p><div class='card-footer'><a href='${elem.pLink}' id='projectLink${elem.id}' class='card-link justify-content-center'>${elem.pLink}</a><div class="row justify-content-center mt-2"><button class="btn btn-outline-primary col-6" type="button" style="margin-left: 0px !important; width: 48%;" id='pedit${elem.id}' onclick='pedit(${elem.id})'>Edit</button><button class="btn btn-outline-danger col-6" type="button" style="margin-left: 4px !important; width: 48%;" id='pdel${elem.id}' onclick='pdel(${elem.id})'>Delete</button></div></div></div></div>`
          );
        });
      }
    },
  });
}

//add project
$("#projectBtn").click(function (e) {
  $("#projectName").prop("disabled", false);
  e.preventDefault();
  let projectForm = $("#projForm")[0];
  let formdata = new FormData(projectForm);
  $("#projectName").prop("disabled", true);
  formdata.append("email", email);
  if ($("#projectBtn").text() == "✔ Save Project") {
    myurl = "./scripts/apis/editProject.php";
    formdata.append("id", pid);
  } else {
    myurl = "./scripts/apis/addProject.php";
  }
  $.ajax({
    method: "POST",
    enctype: "multipart/form-data",
    url: myurl,
    data: formdata,
    processData: false,
    contentType: false,
    cache: false,
    success: function (data) {
      projectShow();

      //empty fields after addition
      if (data.status == true) {
        $("#projectName").val("");
        createPTechInstance(ar);
        $("#projectDetails").val("");
        $("#projectLink").val("");
        $("#projectImages").val("");
        $("#projImgLabel").text("jpeg, png, webp...");
        $("#projectBtn").text("+ Add project");
        $("#projectBtn").prop("disabled", true);
        $("#projectName").prop("disabled", false);
      }

      snackbar(data);
    },
    error: function (e) {
      console.log("ERROR : ", e);
    },
  });
  changeSite();
});

//project del
function pdel(a) {
  $.ajax({
    method: "POST",
    url: "./scripts/apis/delProject.php",
    data: `pid=${a}`,
    success: function (data) {
      snackbar(data);
      projectShow();
    },
  });
  changeSite();
}

//project edit
function pedit(a) {
  pid = a;
  userProjects.forEach((m) => {
    if (m.id == a) {
      toEdit = m;
    }
  });
  //pdel(toEdit['id']);

  $("#projectName").val(toEdit["pName"]);
  $("#projectName").prop("disabled", true);
  $("#projectDetails").val(toEdit["pDetails"]);
  $("#techStack").val(toEdit["pTech"]);
  $("#projectLink").val(toEdit["pLink"]);
  $("#projImgLabel").text(toEdit["pImage"]);
  document.documentElement.scrollIntoView();

  ptech = toEdit["pTech"] ? toEdit["pTech"].split(",") : "";
  createPTechInstance(ptech);

  $("#projectBtn").text("✔ Save Project");
  $("#projectBtn").prop("disabled", false);
}

function activeFile() {
  $("#projectImages").trigger("click");
}

$("#projectImages").change(() => {
  pim = $("#projectImages")[0].files.item(0).name;
  $("#projImgLabel").text(pim);
});
