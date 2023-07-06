var keyword = document.getElementById('keyword');
var container = document.getElementById('container');

keyword.addEventListener('keyup', function(){
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function(){
    if(xhr.readyState == 4 && xhr.status == 200){
      container.innerHTML = xhr.responseText;
    }
  }
  xhr.open('GET', 'posts.php?keyword=' + keyword.value, true);
  xhr.send();
});

document.addEventListener("DOMContentLoaded", function() {
    var menuToggle = document.querySelector(".menu-toggle");
    menuToggle.addEventListener("click", function() {
        var nav = document.querySelector(".nav");
        var navUl = document.querySelector(".nav ul");
        nav.classList.toggle("showing");
        navUl.classList.toggle("showing");
    });;
});

ClassicEditor.create(document.querySelector("#body"), {
    toolbar: [
        "heading",
        "|",
        "bold",
        "italic",
        "link",
        "bulletedList",
        "numberedList",
        "blockQuote"
    ],
    heading: {
        options: [
            { model: "paragraph", title: "Paragraph", class: "ck-heading_paragraph" },
            {
                model: "heading1",
                view: "h1",
                title: "Heading 1",
                class: "ck-heading_heading1"
            },
            {
                model: "heading2",
                view: "h2",
                title: "Heading 2",
                class: "ck-heading_heading2"
            }
        ]
    }
}).catch(function(error) {
    console.log(error);
});


