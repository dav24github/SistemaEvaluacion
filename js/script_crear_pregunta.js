$(document).ready(function() {

    var nro_op, nro_res;
    var t_pregunta = document.getElementById("t_pregunta").value;

    if (t_pregunta != "") {
        if (t_pregunta == "falso_verdadero") {
            $("#falso_verdadero").show();
            $("#opcion_simple").hide();
            $("#opcion_multiple").hide();
        }
        if (t_pregunta == "opcion_simple") {
            $("#falso_verdadero").hide();
            $("#opcion_simple").show();
            $("#opcion_multiple").hide();
        }
        if (t_pregunta == "opcion_multiple") {
            $("#falso_verdadero").hide();
            $("#opcion_simple").hide();
            $("#opcion_multiple").show();
        }
    } else {
        $("#falso_verdadero").hide();
        $("#opcion_simple").hide();
        $("#opcion_multiple").hide();
    }

    $("#f_v").on("click", function() {
        nro_op = 1;
        nro_res = 1;
        $("#falso_verdadero").show();
        $("#opcion_simple").hide();
        $("#opcion_multiple").hide();
    });

    $("#osimple").on("click", function() {
        nro_op = 1;
        nro_res = 1;
        $("#falso_verdadero").hide();
        $("#opcion_simple").show();
        $("#opcion_multiple").hide();
    });

    $("#omultiple").on("click", function() {
        nro_op = 1;
        nro_res = 1;
        $("#falso_verdadero").hide();
        $("#opcion_simple").hide();
        $("#opcion_multiple").show();
    });

    $(".add_opcion").click(function(e) {
        e.preventDefault();
        nro_op++;
        $(".items_opciones").append('<div><input type="text" name="opcion' + nro_op + '">' +
            '<select id="sancion_porcentual' + nro_op + '" name="sancion_porcentual' + nro_op + '"><option value=""></option><option value="0">0</option><option value="-20">-20</option><option value="-25">-25</option><option value="-33.3">-33.33</option><option value="-50">-50</option><option value="-100">-100</option></select>' +
            '<input type="button" value="X" class="delete" /></div>');
        $(".nro_opciones").val(nro_op);
    });

    $(".add_respuesta").click(function(e) {
        e.preventDefault();
        nro_res++;
        $(".items_respuestas").append('<div><input type="text" name="respuesta' + nro_res + '">' +
            '<select id="valor_porcentual' + nro_res + '" name="valor_porcentual' + nro_res + '"><option value=""></option><option value="0">0</option><option value="20">20</option><option value="25">25</option><option value="33.3">33.33</option><option value="50">50</option><option value="100">100</option></select>' +
            '<input type="button" value="X" class="delete" /></div>');

        $(".nro_respuestas").val(nro_res);
    });

    $('body').on('click', '.delete', function(e) {
        $(this).parent('div').remove();
    });
});

function buscar_fv() {
    var id_test = document.getElementById("id_test").value;
    var opcion = document.getElementById("pregunta_reutilizada_fv").value;
    var tipo_pregunta = document.getElementById("tipo_pregunta_fv").value;
    window.location.href = 'crear_pregunta.php?id_test=' + id_test + '&id_pregunta=' + opcion + '&tipo_pregunta=' + tipo_pregunta;
}

function buscar_simple() {
    var id_test = document.getElementById("id_test").value;
    var opcion = document.getElementById("pregunta_reutilizada_simple").value;
    var tipo_pregunta = document.getElementById("tipo_pregunta_simple").value;
    window.location.href = 'crear_pregunta.php?id_test=' + id_test + '&id_pregunta=' + opcion + '&tipo_pregunta=' + tipo_pregunta;
}

function buscar_multiple() {
    var id_test = document.getElementById("id_test").value;
    var opcion = document.getElementById("pregunta_reutilizada_multiple").value;
    var tipo_pregunta = document.getElementById("tipo_pregunta_multiple").value;
    window.location.href = 'crear_pregunta.php?id_test=' + id_test + '&id_pregunta=' + opcion + '&tipo_pregunta=' + tipo_pregunta;
}