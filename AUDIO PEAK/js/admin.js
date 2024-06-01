let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function() {
  sidebar.classList.toggle("active");
  if(sidebar.classList.contains("active")){
  sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
}else
  sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
}


function showLogin() {
  document.querySelector(".login-container").style.display = "flex";
}

function closePopup() {
  document.querySelector(".addup-container-1").style.display = "none";
}
function showPopup() {
  document.querySelector(".addup-container-1").style.display = "flex";
}

function adminDeleteAlert(accountId) {
  Swal.fire({
    title: "Delete this account",
    backgroundColor: "blue",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Delete",
  }).then((result) => {
    if (result.isConfirmed) {
      // Proceed with deletion logic using accountId (if confirmed)
      window.location.href = "admin.php?delete=" + accountId;
    }
  });
}
function orderDeleteAlert(orderId) {
  Swal.fire({
    title: 'Delete this order?',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Delete'
  }).then((result) => {
    if (result.isConfirmed) {
      // Proceed with deletion logic using orderId (if confirmed)
      window.location.href = "orders.php?delete=" + orderId;
    }
  });
}
function productDeleteAlert(productId) {
  Swal.fire({
    title: 'Delete this product?',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Delete'
  }).then((result) => {
    if (result.isConfirmed) {
      // Proceed with deletion logic using orderId (if confirmed)
      window.location.href = "products.php?delete=" + productId;
    }
  });
}
function userDeleteAlert(userId) {
  Swal.fire({
    title: 'Delete this user?',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Delete'
  }).then((result) => {
    if (result.isConfirmed) {
      // Proceed with deletion logic using orderId (if confirmed)
      window.location.href = "users.php?delete=" + userId;
    }
  });
}