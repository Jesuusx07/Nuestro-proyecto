document.addEventListener("DOMContentLoaded", function () {
    let ctx = document.getElementById("weeklyChart").getContext("2d");
    new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"],
            datasets: [{
                label: "Domicilios Semanales",
                data: [5, 10, 8, 6, 12, 15, 9],
                backgroundColor: "rgba(155, 11, 11, 0.86)",
                borderColor: "rgb(223, 8, 8)",
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});

togglePassword.addEventListener('click', () => {
    const isPassword = passwordInput.getAttribute('type') === 'password';
    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
    togglePassword.classList.toggle('active', isPassword);
});
