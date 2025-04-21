// grades Popup Modal
document.addEventListener("DOMContentLoaded", () => {
    const openModalBtn = document.getElementById("openModalBtn");
    const modal = document.getElementById("confirmationModal");
    const noBtn = document.querySelector(".modal-buttons .no");
    const yesBtn = document.querySelector(".modal-buttons .yes");

    modal.style.display = "none";

    openModalBtn.addEventListener("click", () => {
      modal.style.display = "flex";
    });

    noBtn.addEventListener("click", () => {
      modal.style.display = "none";
    });

    yesBtn.addEventListener("click", () => {
      modal.style.display = "none";
      alert("Të dhënat u ruajtën me sukses!");
    });
  });