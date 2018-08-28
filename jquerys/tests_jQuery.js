$(document).ready(function () {
	$('#title').html('jQuery');

	$('form').submit(function () {
		var name = $(':input[name=name]').val();
		var email = $(':input[name=email]').val();
		var tel = $(':input[name=tel]').val();
		var term = $(':input[name=term]').is(":checked");

		var error = "";
		$('#errors').html("");

		if (name === ""){
			error += "<p>Preencha um nome.</p>";
		}
		if (email === ""){
			error += "<p>Preencha um email.</p>";
		}
		if (tel === ""){
			error += "<p>Preencha um telefone.</p>";
		}
		if (!term){
			error += "<p>Aceite os termos.</p>";
		}
		if (error){
			$('#errors').html(error);
			return false;
		}
	});






});