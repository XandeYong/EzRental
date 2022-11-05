// pop out form for fill banned reasons
function openForm(accountID) {
    document.getElementById('accountID').value = accountID;
  document.getElementById("banForm").style.display = "block";
  
};

function closeForm() {
  document.getElementById("banForm").style.display = "none";
};