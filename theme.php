<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
     <button id="themeToggle" class="theme-btn">🌙</button>

<script>
const themeToggle = document.getElementById("themeToggle");

// Apply saved theme on page load
if(localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark");
    themeToggle.innerText = "💡";
}

themeToggle.addEventListener("click", () => {
    document.body.classList.toggle("dark");

    if (document.body.classList.contains("dark")) {
        themeToggle.innerText = "💡";
        localStorage.setItem("theme", "dark");
    } else {
        themeToggle.innerText = "🌙";
        localStorage.setItem("theme", "light");
    }
});

</script>

</body>
</html>