// Add event listener to the "Add Notice" button
  document.getElementById("newNoticeBtn").addEventListener("click", () => {
    document.getElementById("noticeFormModal").classList.remove("hidden");
  });
  
  document.getElementById("noticeForm").addEventListener("submit", function (e) {
    e.preventDefault();
  
    const title = document.getElementById("title").value;
    const date = document.getElementById("date").value;
    const description = document.getElementById("description").value;
    const author = document.getElementById("author").value;
  
    const card = document.createElement("div");
    card.className = "notice-card";
    card.innerHTML = `
      <h3>${title}</h3>
      <p><small>${date}</small></p>
      <p>${description}</p>
      <p><strong>${author}</strong></p>
    `;
  
    document.getElementById("noticesContainer").prepend(card);
  
    document.getElementById("noticeForm").reset();
    document.getElementById("noticeFormModal").classList.add("hidden");
  });
  
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      document.getElementById("noticeFormModal").classList.add("hidden");
    }
  });

//grades modal

function openGradeModal() {
      document.getElementById("modal-grades").style.display = "block";
  }

function closeGradeModal() {
      document.getElementById("modal-grades").style.display = "none";
    }

window.onclick = function(event) {
      const modal = document.getElementById("modal-grades");
      if (event.target === modal) {
        closeGradeModal();
      }
}

function submitGrades() {
      alert("Nota u ruajt! (vetëm në front për testim)");
      closeGradeModal();
}

//comments modal

function openCommentModal() {
      document.getElementById("modal-comments").style.display = "block";
    }
    
    function closeCommentModal() {
      document.getElementById("modal-comments").style.display = "none";
    }
    
    function submitComment() {
      alert("Koment u ruajt! (Vetëm në frontend për testim)");
      closeCommentModal();
}
    