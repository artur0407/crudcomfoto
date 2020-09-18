$("#cpf").mask("000.000.000-00");
$("#celular").mask("(00) 00000-0000");
$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});