// setelah navbar dimuat, tambahkan fungsionalitas scroll
const navbar = document.getElementById("navbar");
let lastScroll = 0;
let hideTimeout;

// window.addEventListener("scroll", function () {
//     const currentScroll = window.scrollY;

//     if (currentScroll > lastScroll) {
//         // scroll ke bawah 🐧
//         clearTimeout(hideTimeout);
//         hideTimeout = setTimeout(() => {
//             navbar.style.top = "-25%";
//         }, 0);
//     } else {
//         // scroll ke atas 🐧
//         clearTimeout(hideTimeout);
//         navbar.style.top = "0";
//     }
//     lastScroll = currentScroll
// });