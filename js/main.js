{
    let $divConv;
	let componentes;
	let init = function() {
        $divConv = $('#addConvocatoria');
        $divConv.hide();
        
        $('#add_convocatoria').click(cargaContenido);

		$("[id*=estados]").hide();

		$( '[id*=acciones]' ).children('#cambiarEstado').each(function(index) {
			$(this).on("click", function(){
				//$(this).parent('#acciones').hide();
				$($( '[id*=acciones]' ).children('#estados')[index]).toggle('slow');
			});
		});

		$('#add_componente').on('click', function(){
			$('#wrapComponentes').append( '<div id="componentes">' + 
			'<label for="nombre_componente">Nombre del componente</label><br><br>' + 
			'<input type="text" name="nombre_componente[]" id="nombre_componente"><br><br>'+
			'<label for="email_componente">Email del componente</label><br><br>'+
			'<input type="email" name="email_componente[]" id="email_componente"><br><br>'+
			'<label for="imagen_componente">Imagen del componente</label><br><br>'+
			'<input type="file" name="imagen_componente[]" id="imagen_componente"><br><br>'+
		'</div>' ); // append -> object
		 });
	}
	
	/** Carga el contenido principal según el enlace seleccionado */
	let cargaContenido = function(event) {
		$divConv.toggle("slow");
	}


	
	$(init)
}