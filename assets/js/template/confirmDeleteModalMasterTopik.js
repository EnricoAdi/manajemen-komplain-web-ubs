function deleteTopik(event) {
    event.preventDefault(); 
    $('#confirmDeleteModal').modal('show');
}
let btnDelete = document.getElementById("btnDelete");
btnDelete.addEventListener("click", deleteTopik);
