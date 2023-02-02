// document.querySelector("#btn").addEventListener("click", function () {
//   const txt = "HELLO FROM JAVASCRIPT";
//   document.querySelector("#demo").innerHTML = txt;
// });

//------------------------------------Sidebar menu open and close ---------------------------
function openNav() {
  document.getElementById("mySideNav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySideNav").style.width = "0";
}

//-----------------------------------Auto adjusting iframe height onload ---------------------

function AdjustIframeHeightOnLoad() {
  document.getElementById("iPage").style.height =
    document.getElementById("iPage").contentWindow.document.body.scrollHeight +
    "px";
}

function AdjustIframeHeight(i) {
  document.getElementById("iPage").style.height = parseInt(i) + "px";
}
