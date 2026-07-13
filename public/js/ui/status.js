const status = document.getElementById("status");


export function showStatus(message, type = "") {

    status.textContent = message;

    status.className = type;


    setTimeout(() => {
        status.textContent = "";
        status.className = "";
    }, 3000);
}