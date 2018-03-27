// Default Script included on every page

// Adds the '.responsive' class to Nav objects to allow it to look good on small screens
function setResponsiveNav() {
    var x = document.getElementById("mainTopNav");
    if (x.className === "topNav") {
        x.className += " responsive";
    } else {
        x.className = "topNav";
    }
}