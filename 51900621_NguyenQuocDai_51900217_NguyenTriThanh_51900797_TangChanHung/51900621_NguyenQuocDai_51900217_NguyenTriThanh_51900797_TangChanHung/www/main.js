function footer(){
    var year = new Date().getFullYear();
    document.write(year);
}

function editUser(){
    $('#button-edit').on('click',function(){
        alert('Đã click');
    });
}
$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

// $(document).ready( function () {
//     $('#customTable').DataTable();
// });

// $(function () {
//     $('#customTable').DataTable({
//         'paging': true,
//         'lengthChange': true,
//         'searching': true,
//         'ordering': false,
//         'info': true,
//         'autoWidth': true
//     })
// })





